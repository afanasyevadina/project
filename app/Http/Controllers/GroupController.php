<?php

namespace App\Http\Controllers;
use App\Group;
use App\GroupGraphic;
use App\Department;
use App\Lang;

use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('groups.index', [
            'groups' => Group::orderBy('department_id', 'asc')
            ->orderBy('year_create', 'desc')
            ->orderBy('lang_id', 'asc')
            ->orderBy('name', 'asc')
            ->get(),
            'departments' => Department::all(),
            'langs' => Lang::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $group = Group::create($request->all());
        $group->save();
        return redirect()->route('groups');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $group = Group::find($id);
        $group->fill($request->all());
        $group->save();
        return redirect()->route('groups');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::find($id);
        $group->delete();
        return redirect()->route('groups');
    }

    public function graphic(Request $request, $id)
    {
        $graphic = GroupGraphic::updateOrCreate(['group_id' => $id], $request->all());
        $graphic->save();
        return back();
    }
}
