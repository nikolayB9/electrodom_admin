<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeasureUnit\StoreRequest;
use App\Http\Requests\MeasureUnit\UpdateRequest;
use App\Models\MeasureUnit;

class MeasureUnitController extends Controller
{
    public function index()
    {
        $measureUnits = MeasureUnit::orderBy('title')->get();
        return view('measure-unit.index', compact('measureUnits'));
    }

    public function store(StoreRequest $request)
    {
        $measureUnit = MeasureUnit::create([
            'title' => $request->validated('title'),
        ]);
        return redirect()->route('measure-units.index')->with('status', 'Единица измерения "' . $measureUnit->title . '" успешно сохранена.');
    }

    public function update(UpdateRequest $request, MeasureUnit $measureUnit)
    {
        $measureUnit->update([
            'title' => $request->validated('title'),
        ]);
        return redirect()->route('measure-units.index')->with('status', 'Единица измерения "' . $measureUnit->title . '" успешно обновлена.');
    }

    public function destroy(MeasureUnit $measureUnit)
    {
        if ($measureUnit->belongsToTheAttribute()) {
            return back()->withErrors(['measureUnitDeletion' => 'You cannot delete a unit of measurement "' . $measureUnit->title . '" that is used by at least one attribute']);
        }
        $title = $measureUnit->title;
        $measureUnit->delete();
        return redirect()->route('measure-units.index')->with('status', 'Единица измерения "' . $title . '" удалена.');
    }
}
