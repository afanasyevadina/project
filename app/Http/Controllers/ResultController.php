<?php

namespace App\Http\Controllers;

use App\Result;
use App\Teacher;
use App\Group;
use App\Student;
use App\Plan;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $group = \Request::get('group');
        $sem = \Request::get('sem');
        $user = \Auth::user();
        $dis = Plan::where(function($q) {
        	$q->whereHas('subject', function($sq) {
        		$sq->where('divide', '<>', 2);
        	})
        	->orWhere('subgroup', '<>', 2);
        })
        ->whereNotIn('cikl_id', [7,8,9])
        ->when($group, function($query, $group) {
            $query->where('group_id', $group);
        })
        ->when($sem, function($query, $sem) {
            $query->where('semestr', $sem);
        })
        ->when($user->role == 'teacher', function($query) use($user) {
            $query->where('teacher_id', $user->person_id);
        })
        ->orderBy('year', 'asc')
        ->orderBy('semestr', 'asc')
        ->orderBy('subject_id', 'asc')
        ->orderBy('subgroup', 'asc')
        ->paginate(30);
        return view('result.index', [
            'dis' => $dis,
            'groups' => Group::orderBy('name')->get(),
        ]);
    }

    public function edit($id)
    {
    	$plan = Plan::findOrFail($id);
        if(\Auth::user()->cant('update', $plan)) abort(403);
    	$plan->generateResults();
    	$results = Result::where('plan_id', $id)->get();
    	return view('result.edit', [
            'plan' => $plan,
            'results' => $results,
        ]);
    }

    public function store(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);
        if(\Auth::user()->cant('update', $plan)) abort(403);
        foreach ($request->results as $id => $res) {
            $result = Result::find($id);
            $result->fill($res);
            $result->save();
        }
    }

    public function view($id)
    {
        $student = Student::findOrFail($id);
        $plans = Plan::where('group_id', $student->group_id)
        ->whereIn('subgroup', [0, $student->subgroup])
        ->whereNotIn('cikl_id', [7,8,9])
        ->where('semestr', '<=', $student->group->kurs * 2)
        ->orderBy('semestr', 'asc')->get(); 
        $zachetka = [];
        foreach ($plans as $key => $plan) {
            $result = Result::updateOrCreate([
                'plan_id' => $plan->id,
                'student_id' => $id
            ]);
            $zachetka[$plan->semestr][] = $result;
        }
        ksort($zachetka);
        return view('result.view', [
            'student' => $student,
            'zachetka' => $zachetka,
        ]);
    }
}
