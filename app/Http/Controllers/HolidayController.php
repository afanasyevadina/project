<?php

namespace App\Http\Controllers;
use App\Holiday;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HolidayController extends Controller
{
    public function index()
    {
        return view('holiday.index', [
            'holidays' => Holiday::orderBy('date', 'asc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $holiday = Holiday::create($request->all());
        $holiday->save();
    }

    public function update(Request $request, $id)
    {
        $holiday = Holiday::findOrFail($id);
        $holiday->fill($request->all());
        $holiday->save();
    }

    public function destroy($id)
    {
        $holiday = Holiday::findOrFail($id);
        $holiday->delete();
    }
}