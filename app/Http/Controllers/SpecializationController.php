<?php

namespace App\Http\Controllers;
use App\Department;
use App\Specialization;

use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specializations = Specialization::orderBy('name', 'asc')->get();
        return view('specialization.index', [
            'specializations' => $specializations,
            'departments' => Department::all(),
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
        $spec = Specialization::create($request->all());
        $spec->save();
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
        $spec = Specialization::findOrFail($id);
        $spec->fill($request->all());
        $spec->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $spec = Specialization::findOrFail($id);
        $spec->delete();
    }
}
