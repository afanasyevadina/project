<?php

namespace App\Http\Controllers;
use App\Plan;
use App\Subject;
use App\Group;
use App\Cikl;
use App\Teacher;
use App\Student;
use App\Rating;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JournalController extends Controller
{
    public function index()
    {
        $group = \Request::get('group');
        $sem = \Request::get('sem');
        $user = \Auth::user();
        $journals = Plan::when($group, function($query, $group) {
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
        return view('journal.index', [
            'journals' => $journals,
            'groups' => Group::orderBy('name')->get(),
        ]);
    }

    public function view($id)
    {
        $data = Plan::findOrFail($id);
        if($data->group->students()->count() && !Rating::whereHas('lesson', function($query) use($id) {
            $query->where('plan_id', $id);
        })->count()) {
            $data->generateRatings();
            return redirect()->refresh();
        }
        $query = Student::where('group_id', $data->group_id);
        if($data->subgroup == 2 || $data->subject->divide == 1) {
            $query->where('subgroup', $data->subgroup);
        }        
        $students = $query->orderBy('surname', 'asc')
        ->orderBy('name', 'asc')->get();
        return view('journal.view', [
            'plan' => $data,
            'students' => $students,
        ]);
    }

    public function refresh($id)
    {
        $data = Plan::findOrFail($id);
        $data->generateRatings();
        return redirect()->back();
    }

    public function store(Request $request)
    {
        foreach($request->all() as $item) {
            $rating = Rating::find($item['id']);
            $rating->value = is_numeric($item['value']) ? $item['value'] : null;
            $rating->miss = mb_strtolower($item['value']) == 'н';
            $rating->save();
        }
    }

    public function report()
    {
        $group = \Request::get('group');
        $semestr = \Request::get('semestr');
        $subjects = Plan::select('subject_id')
        ->where('group_id', $group)
        ->where('semestr', $semestr)
        ->whereNotIn('cikl_id', [6,7,8,9])
        ->distinct()->get();
        return view('journal.report', [
            'groups' => Group::orderBy('name')->get(),
            'group' => Group::find($group),
            'subjects' => $subjects,
        ]);
    }
}
