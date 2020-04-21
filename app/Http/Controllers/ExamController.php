<?php

namespace App\Http\Controllers;

use App\Group;
use App\Plan;
use App\Cab;
use App\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $group = \Request::get('group');
        $semestr = \Request::get('semestr');
        $exams = Plan::where('group_id', $group)
        ->where('semestr', $semestr)
        ->where('is_exam', 1)->get();
        return view('exam.index', [
            'groups' => Group::orderBy('name', 'asc')->get(),
            'exams' => $exams,
            'group' => Group::findOrFail($group),
        ]);
    }

    public function edit()
    {
        $group = \Request::get('group');
        $semestr = \Request::get('semestr');
        $exams = Plan::where('group_id', $group)
        ->where('semestr', $semestr)
        ->where('is_exam', 1)->get();
        return view('exam.edit', [
            'groups' => Group::orderBy('name', 'asc')->get(),
            'exams' => $exams,
            'group' => Group::findOrFail($group),
            'cabs' => Cab::orderBy('num', 'asc')->get(),
        ]);
    }

    public function store(Request $request)
    {
        foreach ($request->exams as $id => $ex) {
            $exam = Exam::firstOrCreate(['plan_id' => $id]);
            $exam->fill($ex);
            $exam->save();
        }
    }
}
