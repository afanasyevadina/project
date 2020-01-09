<?php

namespace App\Http\Controllers;
use App\CollegeGraphic;
use App\Group;
use App\DateConvert;

use Illuminate\Http\Request;

class GraphicController extends Controller
{
    public function index()
    {
        return view('graphic.index', [
            'graphic' => CollegeGraphic::orderBy('year', 'asc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $graphic = CollegeGraphic::create($request->all());
        $graphic->save();
        return redirect()->route('graphic');
    }

    public function update(Request $request, $id)
    {
        $graphic = CollegeGraphic::find($id);
        $graphic->fill($request->all());
        $graphic->save();
        return redirect()->route('graphic');
    }

    public function destroy($id)
    {
        $graphic = CollegeGraphic::find($id);
        $graphic->delete();
        return redirect()->route('graphic');
    }
}
