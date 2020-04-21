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
        $query = Plan::where(function($q) {
        	$q->whereHas('subject', function($sq) {
        		$sq->where('divide', '<>', 2);
        	})
        	->orWhere('subgroup', '<>', 2);
        }); 
        if($group) {
            $query->where('group_id', $group);
        }
        if($sem) {
            $query->where('semestr', $sem);
        }
        if(\Auth::user()->role == 'teacher') {
            $query->where('teacher_id', \Auth::user()->person_id);
        }
        $dis = $query->orderBy('year', 'asc')
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
    	$query = Student::where('group_id', $plan->group_id);
        if($plan->subgroup == 2 || $plan->subject->divide == 1) {
            $query->where('subgroup', $plan->subgroup);
        }        
        $students = $query->orderBy('surname', 'asc')
        ->orderBy('name', 'asc')->get();
    	foreach ($students as $key => $student) {
    		$result = Result::updateOrCreate([
    			'plan_id' => $id,
    			'student_id' => $student->id
    		]);
    		$result->save();
    	}
    	$results = Result::where('plan_id', $id)->get();
    	return view('result.edit', [
            'plan' => $plan,
            'results' => $results,
        ]);
    }

    public function store(Request $request)
    {
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
        ->orderBy('semestr', 'asc')->get(); 
        foreach ($plans as $key => $plan) {
            $result = Result::updateOrCreate([
                'plan_id' => $plan->id,
                'student_id' => $id
            ]);
            $result->save();
        }
        $results = Result::where('student_id', $id)->get();
        $zachetka = [];
        foreach ($results as $key => $result) {
            $zachetka[$result->plan->semestr][] = $result;
        }
        ksort($zachetka);
        return view('result.view', [
            'student' => $student,
            'zachetka' => $zachetka,
        ]);
    }
}
