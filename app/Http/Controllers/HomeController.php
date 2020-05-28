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
            $subjects = Plan::where('teacher_id', $teacher->id)
            ->when(date('n') < 9, function($query) {
                $query->where('year', date('Y') - 1)->whereIn('semestr', [2,4,6,8]);
            })
            ->when(date('n') >= 9, function($query) {
                $query->where('year', date('Y'))->whereIn('semestr', [1,3,5,7]);
            })->get();
            $progress = $subjects->filter(function($val) {
                return $val->results()->where('itog', '>', 2)->count() == $val->results()->count() &&  $val->results()->count();
            })->count();
            return view('home.teacher', [
                'teacher' => $teacher,
                'subjects' => $subjects,
                'progress' => $progress,
            ]);
            break;
            case 'student':
            $student = Student::findOrFail(\Auth::user()->person_id);
            $subjects = $student->results()->whereHas('plan', function($query) {
                if(date('n') < 9) $query->where('year', date('Y') - 1)->whereIn('semestr', [2,4,6,8]);
                else $query->where('year', date('Y'))->whereIn('semestr', [1,3,5,7]);
            })->get();
            $progress = $subjects->where('itog', '>', 2)->count();
            return view('home.student', [
                'student' => $student,
                'subjects' => $subjects,
                'progress' => $progress,
            ]);
            break;

            default:
                return view('home.admin');
            break;
        }        
    }
}
