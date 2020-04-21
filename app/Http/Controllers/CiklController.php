<?php

namespace App\Http\Controllers;
use App\Cikl;

use Illuminate\Http\Request;

class CiklController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cikls = Cikl::all();
        return view('cikl.index', [
            'cikls' => $cikls,
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
        $cikl = Cikl::create($request->all());
        $cikl->save();
    }

    /**
   
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cikl = Cikl::findOrFail($id);
        $cikl->fill($request->all());
        $cikl->save();
    }

    /**
    
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cikl = Cikl::findOrFail($id);
        $cikl->delete();
    }
}
