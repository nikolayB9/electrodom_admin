<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService extends ImageHandlerService
{
    public function getAttributesWithUnitTitle(int $productId): \Illuminate\Support\Collection
    {
        $attributes = DB::select(
            'SELECT a.id, CONCAT_WS(", ", a.title, m_u.title) AS fullTitle, a_p.value
            FROM attributes AS a LEFT JOIN measure_units AS m_u ON a.measure_unit_id = m_u.id
            INNER JOIN attribute_product AS a_p ON a_p.product_id = :productId
            WHERE a.id = a_p.attribute_id
            ORDER BY a.title', ['productId' => $productId]
        );

        return collect($attributes);
    }

    public function add(array $data): Product
    {
        $data = $this->processImageSaving($data);
        $data['is_published'] = !empty($data['is_published']);

        return DB::transaction(function () use ($data) {
            $product = Product::create($data);

            $attributesIds = $product->category->attributes->modelKeys();
            $product->attributes()->attach($attributesIds);

            return $product;
        });
    }

    public function change(Product $product, array $data): void
    {
        $data = $this->processImageUpdating($product, $data);
        $data['is_published'] = !empty($data['is_published']);

        DB::transaction(function () use ($product, $data) {
            $this->processAttributesUpdating($product, $data);

            $product->update($data);
        });
    }

    public function changeAttributesValues(Product $product, array $data): void
    {
        $dataPivot = [];
        foreach ($data['attributes_ids'] as $id => $value) {
            $dataPivot[$id]['value'] = $value;
        }

        /* Editing records in the pivot table in one query */
        $product->attributes()->sync($dataPivot);
    }

    public function remove(Product $product): void
    {
        if (!empty($product->image)) {
            $this->deleteFromDisk($product->image);
        }

        DB::transaction(function () use ($product) {
            $product->attributes()->detach();
            $product->delete();
        });
    }

    public static function getPathToSave(): string
    {
        return config('images.product.path_to_save');
    }

    public static function getPathToDefault(): string
    {
        return config('images.product.default');
    }

    public static function getImgParams(): array
    {
        return config('images.product');
    }

    private function processImageSaving(array $data): array
    {
        if (!empty($data['image'])) {
            $data['image'] = $this->saveToDisk($data['image']);
        }
        return $data;
    }

    private function processImageUpdating(Product $product, array $data): array
    {
        if (!empty($data['image'])) {
            if (!empty($product->image)) {
                $this->deleteFromDisk($product->image);
            }
            $data['image'] = $this->saveToDisk($data['image']);
        } elseif (!empty($data['delete_image'])) {
            if (!empty($product->image)) {
                $this->deleteFromDisk($product->image);
            }
            $data['image'] = null;
        } else {
            $data['image'] = $product->image;
        }

        if (isset($data['delete_image'])) {
            unset($data['delete_image']);
        }

        return $data;
    }

    private function processAttributesUpdating(Product $product, array $data): void
    {
        if ($product->getCategoryId() != $data['category_id']) {
            $category = Category::find($data['category_id']);
            $attributesIds = $category->attributes->modelKeys();
            $product->attributes()->sync($attributesIds);
        }
    }
}
