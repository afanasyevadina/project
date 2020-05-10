<?php

namespace App\Http\Controllers;
use App\Cab;
use App\Corpus;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CabController extends Controller
{
    public function index()
    {
        return view('cab.index', [
            'cabs' => Cab::orderBy('num', 'asc')->get(),
            'corps' => Corpus::all(),
        ]);
    }

    public function store(Request $request)
    {
        $cab = Cab::create($request->all());
        $cab->save();
    }

    public function update(Request $request, $id)
    {
        $cab = Cab::findOrFail($id);
        $cab->fill($request->all());
        $cab->save();
    }

    public function destroy($id)
    {
        $cab = Cab::findOrFail($id);
        $cab->delete();
    }
}