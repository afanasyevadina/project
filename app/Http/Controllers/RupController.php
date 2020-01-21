<?php

namespace App\Http\Controllers;
use App\Plan;
use App\Subject;
use App\Group;
use App\Cikl;
use App\Teacher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RupController extends Controller
{
    public function index()
    {
        $kurs = \Request::get('kurs') ?? 1;
        $id = \Request::get('group');
        $group = Group::find($id);
        $all = Plan::where('group_id', $id)
        ->whereIn('semestr', [$kurs * 2 - 1, $kurs * 2])
        ->orderBy('cikl_id', 'asc')
        ->orderBy('subject_id', 'asc')->get();
        $plans = [];
        foreach ($all as $key => $p) {
            $sem = $p->semestr % 2 ? 1 : 2;
            $index = $p->subject_id.$p->subgroup;
            $plans[$index]['teacher'] = $p->teacher;
            $plans[$index]['subject'] = $p->subject;
            @$plans[$index]['control'] += $p->controls;
            $plans[$index]['theory_main'] = $p->theory_main;
            $plans[$index]['practice_main'] = $p->practice_main;
            @$plans[$index]['theory'] += $p->theory;
            @$plans[$index]['practice'] += $p->practice;
            @$plans[$index]['practice'] += $p->lab;
            @$plans[$index]['consul'] += $p->consul;
            @$plans[$index]['exam'] += $p->exam;
            $plans[$index]['sem'.$sem] = $p->total;
            $plans[$index]['weeks'.$sem] = $p->weeks;
            if($p->is_project) {
                $plans[$index]['project'] = $p->project;
                $plans[$index]['project_sem'] = $p->semestr;
            }
            if($p->is_exam)
                $plans[$index]['exam_sem'] = $p->semestr;
            if($p->is_zachet)
                $plans[$index]['zachet_sem'][] = $p->semestr;
        }
        
        return view('rup.index', [
            'plans' => $plans,
            'group' => $group,
            'kurs' => $kurs,
            'teachers' => Teacher::all(),
            'groups' => Group::all(),
        ]);
    }

    public function store(Request $request, $group, $kurs)
    {
        foreach ($request->all()['plan'] as $key => $p) {
            $plans = Plan::where('group_id', $group)
            ->whereIn('semestr', [($kurs * 2 - 1), $kurs * 2])
            ->where('subject_id', $p['subject'])
            ->get();
            foreach($plans as $plan) {
                $plan->teacher_id = $p['teacher_id'];
                $plan->save();
            }
        }
        return redirect()->back();
    }

    public function refresh($id, $kurs)
    {
        $group = Group::find($id);
        $query = Plan::where('group_id', $id)
        ->whereIn('semestr', [$kurs * 2 - 1, $kurs * 2]);
        $plans = $query->get();
        if(count($group->students) < 25) {
            $query->where('subgroup', 2)->delete();
            $query->where('subgroup', 1)->update(['subgroup' => 0]);
        } else {
            foreach ($plans as $key => $plan) {
                if($plan->subject->divide) {
                    $attr = [
                        'group_id' => $plan->group_id,
                        'semestr' => $plan->semestr,
                        'subject_id' => $plan->subject_id,
                        'cikl_id' => $plan->cikl_id,
                        'shifr' => $plan->shifr,
                        'shifr_kz' => $plan->shifr_kz,
                        'is_exam' => $plan->is_exam,
                        'is_zachet' => $plan->is_zachet,
                        'is_project' => $plan->is_project,
                        'practice' => $plan->practice,
                        'practice_main' => $plan->practice_main,
                        'project' => $plan->project,
                        'lab' => $plan->lab,
                        'weeks' => $plan->weeks,
                        'subgroup' => 2
                    ];
                }
                if($plan->subject->divide == 1) {
                    $attr['theory'] = $plan->theory;
                    $attr['theory_main'] = $plan->theory_main;
                    $attr['controls'] = $plan->controls;
                }
                $newPlan = Plan::updateOrCreate($attr);
                $newPlan->save();
                $plan->subgroup = 1;
                $plan->save();
            }
        }
        return redirect()->back();
    }
}
