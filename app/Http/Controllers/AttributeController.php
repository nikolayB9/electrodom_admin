<?php

namespace App\Http\Controllers;

use App\Data\AttributeData;
use App\Http\Requests\Attribute\StoreRequest;
use App\Http\Requests\Attribute\UpdateRequest;
use App\Models\Attribute;
use App\Models\MeasureUnit;
use App\Services\AttributeService;

class AttributeController extends Controller
{
    public function __construct(private AttributeService $attributeService)
    {
    }

    public function index()
    {
        return view('attribute.index', [
            'attributes' => $this->attributeService->getWithFullTitle(),
            'measureUnits' => MeasureUnit::orderBy('title')->get(),
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = AttributeData::from($request->all());
        $attribute = Attribute::create($data->all());
        return back()->with('success', 'Атрибут "' . $attribute->getFullTitle() . '" добавлен.');
    }

    public function update(UpdateRequest $request, Attribute $attribute)
    {
        $data = AttributeData::from($request->all());
        $attribute->update($data->all());
        return back()->with('success', 'Атрибут "' . $attribute->getFullTitle() . '" обновлен.');
    }

    public function destroy(Attribute $attribute)
    {
        if (!$attribute->canBeDeleted()) {
            return back()->with('error', 'Атрибут "' . $attribute->getFullTitle() . '" нельзя удалить.');
        }

        $attribute->delete();
        return back()->with('success', 'Атрибут "' . $attribute->getFullTitle() . '" удален.');
    }
}
