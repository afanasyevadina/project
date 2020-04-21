<?php

namespace App\Http\Controllers\Api;
use App\Group;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Group::with('specialization')
        ->with('lang')
        ->orderBy('specialization_id', 'asc')
        ->orderBy('year_create', 'asc')
        ->orderBy('lang_id', 'asc')
        ->get();
    }
}
