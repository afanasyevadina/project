<?php

namespace App\Http\Controllers;
use App\Plan;
use App\Subject;
use App\Group;
use App\Cikl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RupController extends Controller
{
    public function index($id)
    {
        $kurs = \Request::get('kurs') ?? 1;
        $group = Group::find($id);
        $all = Plan::where('group_id', $id)
        ->whereIn('semestr', [$kurs * 2 - 1, $kurs * 2])
        ->orderBy('cikl_id', 'asc')
        ->orderBy('subject_id', 'asc')->get();
        $plans = [];
        foreach ($all as $key => $p) {
            $sem = $p->semestr % 2 ? 1 : 2;
            $plans[$p->subject_id]['teacher'] = $p->teacher;
            $plans[$p->subject_id]['subject'] = $p->subject;
            @$plans[$p->subject_id]['control'] += $p->controls;
            $plans[$p->subject_id]['theory_main'] = $p->theory_main;
            $plans[$p->subject_id]['practice_main'] = $p->practice_main;
            @$plans[$p->subject_id]['theory'] += $p->theory;
            @$plans[$p->subject_id]['practice'] += $p->practice;
            @$plans[$p->subject_id]['practice'] += $p->lab;
            @$plans[$p->subject_id]['consul'] += $p->consul;
            @$plans[$p->subject_id]['exam'] += $p->exam;
            $plans[$p->subject_id]['sem'.$sem] = $p->total;
            $plans[$p->subject_id]['weeks'.$sem] = $p->weeks;
            if($p->is_project) {
                $plans[$p->subject_id]['project'] = $p->project;
                $plans[$p->subject_id]['project_sem'] = $p->semestr;
            }
            if($p->is_exam)
                $plans[$p->subject_id]['exam_sem'] = $p->semestr;
            if($p->is_zachet)
                $plans[$p->subject_id]['zachet_sem'][] = $p->semestr;
        }
        
        return view('rup.index', [
            'plans' => $plans,
            'group' => $group,
            'kurs' => $kurs,
        ]);
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
        return redirect()->route('rup', ['kurs' => $kurs]);
    }
}
