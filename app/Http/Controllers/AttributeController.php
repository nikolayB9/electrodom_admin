<?php

namespace App\Http\Controllers;

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
        $attribute = Attribute::create([
            'title' => $request->title,
            'measure_unit_id' => $this->attributeService->processMeasureUnit($request->validated()),
        ]);
        return back()->with('success', 'Атрибут "' . $attribute->getFullTitle() . '" добавлен.');
    }

    public function update(UpdateRequest $request, Attribute $attribute)
    {
        $attribute->update([
            'title' => $request->title,
            'measure_unit_id' => $this->attributeService->processMeasureUnit($request->validated()),
        ]);
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
