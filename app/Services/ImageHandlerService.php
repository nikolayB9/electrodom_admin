<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

abstract class ImageHandlerService
{
    /**
     * return image path
     */
    public function saveToDisk(UploadedFile $image): string
    {
        return Storage::disk($this->getDiskToSave())->putFile(static::getPathToSave(), $image);
    }

    public function deleteFromDisk(string $imagePath): void
    {
        Storage::disk($this->getDiskToSave())->delete($imagePath);
    }

    abstract public static function getPathToSave(): string;

    abstract public static function getPathToDefault(): string;

    abstract public static function getImgParams(): array;

    protected function getDiskToSave(): string
    {
        return config('images.disk');
    }

}
