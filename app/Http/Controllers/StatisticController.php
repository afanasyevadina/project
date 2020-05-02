<?php

namespace App\Http\Controllers;

use App\Result;
use App\Teacher;
use App\Group;
use App\Student;
use App\Plan;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function top()
    {
        $group = \Request::get('group');
        $year = \Request::get('year');
        $sem = \Request::get('semestr');
        if(!$year) {
            $year = date('Y') - 1;
            $sem = date('n') > 6 ? 2 : 1;
        }
        $top = [];
        $students = Student::when($group, function($query, $group) {
            $query->where('group_id', $group);
        })
        ->whereHas('group', function($query) use($year) {
            $query->where('year_create', '<=', $year)->where('year_leave', '>', $year);
        })->get()->map(function($student) use($year, $sem) {
            return [
                'student' => $student,
                'avg' => round($student->results()->whereHas('plan', function($query) use($year, $sem) {
                    $sems = [1 => [1,3,5,7,9], 2 => [2,4,6,8,10]];
                    $query->where('year', $year)->whereIn('semestr', $sems[$sem]);
                })->avg('itog'), 2)
            ];
        });
        $top = collect($students)->sortByDesc('avg')->slice(0, 100)->values();
        return view('statistic.top', [
            'top' => $top,
            'year' => $year,
            'sem' => $sem,
            'groups' => Group::orderBy('name')->get(),
        ]);
    }

    public function dynamic()
    {
        $student = Student::findOrFail(\Auth::user()->person_id);
        $results = [];
        foreach($student->results as $res) {
            $results[$res->plan->semestr][$res->plan->subject_id] = $res->itog;
        }
        return view('statistic.dynamic', [
            'student' => $student,
            'results' => $results,
        ]);
    }
}
