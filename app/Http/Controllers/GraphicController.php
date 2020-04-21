<?php

namespace App\Http\Controllers;
use App\CollegeGraphic;
use App\Group;
use App\Plan;
use App\DateConvert;

use Illuminate\Http\Request;

class GraphicController extends Controller
{
    public function index()
    {
        $graphic = CollegeGraphic::orderBy('year', 'asc')->get();
        $used = [];
        foreach($graphic as $gr) {
            foreach($gr->groups as $g) {
                $used[$gr->year][] = $g->id;
            }
        }
        return view('graphic.index', [
            'graphic' => $graphic,
            'used' => $used,
            'groups' => Group::orderBy('name', 'asc')->get()
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
        $graphic = CollegeGraphic::findOrFail($id);
        $graphic->fill($request->all());
        $graphic->groups()->sync($request->groups);
        $graphic->save();
        foreach($graphic->groups as $group) {
            Plan::where('year', $graphic->year)
            ->where('group_id', $group->id)
            ->whereIn('semestr', [1, 3, 5, 7])
            ->whereNotIn('cikl_id', [6,7,9])
            ->update(['weeks' => $graphic->teor1]);
            Plan::where('year', $graphic->year)
            ->where('group_id', $group->id)
            ->whereNotIn('cikl_id', [6,7,9])
            ->whereIn('semestr', [2, 4, 6, 8])
            ->whereNotIn('cikl_id', [6, 7, 9])
            ->update(['weeks' => $graphic->teor2]);
        }
        return redirect()->route('graphic');
    }

    public function destroy($id)
    {
        $graphic = CollegeGraphic::findOrFail($id);
        $graphic->groups()->sync([]);
        $graphic->delete();
        return redirect()->route('graphic');
    }
}
