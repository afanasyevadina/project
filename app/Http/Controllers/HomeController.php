<?php

namespace App\Http\Controllers;

use App\Schedule;
use App\Lesson;
use App\Teacher;
use App\Group;
use App\Student;
use App\Plan;
use App\DateConvert;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        switch (\Auth::user()->role) {
            case 'teacher':
            $teacher = Teacher::findOrFail(\Auth::user()->person_id);
            return view('home.teacher', [
                'teacher' => $teacher,
            ]);
            break;
            case 'student':
            $student = Student::findOrFail(\Auth::user()->person_id);           
            $convert = DateConvert::convert(date('Y-m-d'), $student->group_id);
            $semestr = ($convert['year'] - $student->group->year_create) * 2 + $convert['semestr'];
            $allResults = $student->results()->whereHas('plan', function($query) use($semestr) {
                $query->where('semestr', $semestr);
            })->get();
            $results = [];
            foreach($allResults as $res) {
                $results[$res->plan->subject_id] = $res->itog;
            }
            return view('home.student', [
                'student' => $student,
                'results' => $results,
                'subjects' => $student->subjects($semestr),
            ]);
            break;

            default:
                return view('home.admin');
            break;
        }        
    }
}
