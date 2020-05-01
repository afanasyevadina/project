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
            $results = [];
            foreach($student->results as $res) {
                $results[$res->plan->semestr][$res->plan->subject_id] = $res->itog;
            }
            return view('home.student', [
                'student' => $student,
                'results' => $results,
            ]);
            break;

            default:
                return view('home.admin');
            break;
        }        
    }
}
