<?php

namespace App\Http\Controllers;
use App\Group;
use App\Student;
use App\GroupGraphic;
use App\Department;
use App\Specialization;
use App\Lang;
use App\Teacher;

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
        $spec = \Request::get('spec');
        $kurs = \Request::get('kurs');
        $kurs = \Request::get('kurs');
        $lang = \Request::get('lang');
        $base = \Request::get('base');
        $groups = Group::when($spec, function($query, $spec) {
            $query->where('specialization_id', $spec);
        })
        ->when($kurs, function($query, $kurs) {
            $query->where('kurs', $kurs);
        })
        ->when($lang, function($query, $lang) {
            $query->where('lang_id', $lang);
        })
        ->when($base, function($query, $base) {
            $query->where('base', $base);
        })
        ->orderBy('name', 'asc')->get();
        return view('group.index', [
            'groups' => $groups,
            'specializations' => Specialization::all(),
            'langs' => Lang::all(),
            'teachers' => Teacher::all(),
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
        $group = Group::findOrFail($id);
        $group->fill($request->all());
        $group->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();
    }

    public function graphic(Request $request, $id)
    {
        $graphic = GroupGraphic::updateOrCreate(['group_id' => $id], $request->all());
        $graphic->save();
        return back();
    }

    public function students($id)
    {
        $subgroup = \Request::get('subgroup');
        $students = Student::where('group_id', $id);
        if($subgroup) $students->where('subgroup', $subgroup);
        return view('group.students', [
            'students' => $students
            ->orderBy('surname', 'asc')
            ->orderBy('name', 'asc')
            ->orderBy('patronymic', 'asc')->get(),
            'group' => Group::findOrFail($id),
        ]);
    }
}
