<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attribute\StoreRequest;
use App\Http\Requests\Attribute\UpdateRequest;
use App\Models\Attribute;
use App\Models\MeasureUnit;
use App\Services\AttributeService;

class AttributeController extends Controller
{
    public function __construct(public AttributeService $attributeService)
    {
    }

    public function index()
    {
        $attributes = $this->attributeService->getWithUnitTitle();
        return view('attribute.index', compact('attributes'));
    }

    public function create()
    {
        $measureUnits = MeasureUnit::orderBy('title')->get();
        return view('attribute.create', compact('measureUnits'));
    }

    public function store(StoreRequest $request)
    {
        $data = $this->attributeService->processNewMeasureUnit($request->validated());
        $attribute = Attribute::create($data);
        return redirect()->route('attributes.index')->with('status', 'Атрибут "' . $attribute->fullTitle() . '" успешно сохранен.');
    }

    public function edit(Attribute $attribute)
    {
        $measureUnits = MeasureUnit::orderBy('title')->get();
        return view('attribute.edit', compact('attribute', 'measureUnits'));
    }

    public function update(UpdateRequest $request, Attribute $attribute)
    {
        $data = $this->attributeService->processNewMeasureUnit($request->validated());
        $attribute->update($data);
        return redirect()->route('attributes.index')->with('status', 'Атрибут "' . $attribute->fullTitle() . '" успешно обновлен.');
    }

    public function destroy(Attribute $attribute)
    {
//        if (!empty($attribute->categories()->first())) {
//            return back()->withErrors(['deleteError' => 'You cannot delete an attribute "' . $attribute->title . '" that is used by at least one category']);
//        }
        $fullTitle = $attribute->fullTitle();
        $attribute->delete();
        return redirect()->route('attributes.index')->with('status', 'Атрибут "' . $fullTitle . '" удален.');
    }
}
