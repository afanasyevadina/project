<?php

namespace App\Http\Controllers;
use App\Plan;
use App\Subject;
use App\Group;
use App\Cikl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlanController extends Controller
{
    public function index()
    {
        $all = Plan::where('group_id', \Request::get('group'))
        ->where('subgroup', '<>', 2)->get();
        $plans = [];
        foreach ($all as $key => $p) {
            if(!isset($plans[$p->cikl_id]))
                $plans[$p->cikl_id]['cikl'] = $p->cikl;
            $plans[$p->cikl_id]['subjects'][$p->subject_id]['details'][] = $p;
            $plans[$p->cikl_id]['subjects'][$p->subject_id]['shifr'] = $p->shifr;
            $plans[$p->cikl_id]['subjects'][$p->subject_id]['subject'] = $p->subject;
            @$plans[$p->cikl_id]['subjects'][$p->subject_id]['control'] += $p->controls;
            $plans[$p->cikl_id]['subjects'][$p->subject_id]['theory'] = $p->theory_main;
            $plans[$p->cikl_id]['subjects'][$p->subject_id]['practice'] = $p->practice_main;
            $plans[$p->cikl_id]['subjects'][$p->subject_id]['sem'.$p->semestr] = $p->total;
            if($p->is_project) {
                $plans[$p->cikl_id]['subjects'][$p->subject_id]['project'] = $p->project;
                $plans[$p->cikl_id]['subjects'][$p->subject_id]['project_sem'] = $p->semestr;
            }
            if($p->is_exam)
                $plans[$p->cikl_id]['subjects'][$p->subject_id]['exam_sem'] = $p->semestr;
            if($p->is_zachet)
                $plans[$p->cikl_id]['subjects'][$p->subject_id]['zachet_sem'][] = $p->semestr;
        }
        return view('plan.index', [
            'plans' => $plans,
            'groups' => Group::all()
        ]);
    }

    public function upload(Request $request)
    {
        $fileName = Storage::disk('public')->putFile('files', $request->file('file'));
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('public/storage/'.$fileName);
        $sheet = $spreadsheet->getActiveSheet();
        $list = $sheet->toArray();
        $list = array_slice($list, 6);
        $groups = $cikls = $subjects = [];
        foreach (Group::all() as $g) 
            $groups[trim($g->name)] = $g->id;
        foreach (Cikl::all() as $c) 
            $cikls[trim($c->name)] = $c->id;
        foreach (Subject::all() as $s) 
            $subjects[trim($s->name)] = $s->id;

        $cikl = '';

        foreach ($list as $key => $row) {
            if(trim(mb_strtolower($row[1])) == 'итого')
                continue;
            if(isset($cikls[trim($row[1])])) {
                $cikl = $cikls[$row[1]];
                continue;
            }
            if(!isset($subjects[trim($row[1])])) {
                echo "Unexpected ".$row[1];
                return;
            }
            $control = $row[5];
            $theory = $row[7];
            $practice = $row[8];
            for($i = 10; $i < 18; $i++) {
                if($row[$i]) {
                    $semestr = $i - 9;
                    $total = $row[$i];
                    $plan = Plan::updateOrCreate([
                        'group_id' => $request->group,
                        'semestr' => $semestr,
                        'cikl_id' => $cikl,
                        'subject_id' => $subjects[trim($row[1])]
                    ], 
                    [
                        'shifr' => $row[0],
                        'total' => $total,
                        'theory_main' => $row[7],
                        'practice_main' => $row[8]
                    ]
                );
                    if($row[2] == $semestr) {
                        $plan->is_exam = 1;
                        $plan->exam = 2;
                        $plan->consul = 3;
                    }
                    if($row[3] == $semestr) $plan->is_zachet = 1;
                    if($row[4] == $semestr) {
                        $plan->is_project = 1;
                        $plan->project = $row[9];
                    }
                    $left = $total;
                    if($theory >= $total) {
                        $theory -= $total;
                        $plan->theory = $total;
                        $left = 0;
                    } else {
                        $plan->theory = $theory;
                        $left -= $theory;
                        $theory = 0;
                    }
                    if($left) {
                        if($practice >= $left) {
                            $practice -= $left;
                            $plan->practice = $left;
                        } else {
                            $plan->practice = $practice;
                            $practice = 0;
                        }
                    }
                    if($control--) $plan->controls = 1;
                    $plan->save();
                }
            }
        }
        return redirect()->route('plans', ['group' => $request->group]);
    }

    public function store(Request $request)
    {
        foreach ($request->plan as $sbj) {
            $theory = 0;
            $practice = 0;
            $plans = [];
            foreach($sbj as $key => $p) {
                $plan = Plan::find($key);
                $plan->fill($p);
                $theory += $plan->theory;
                $practice += $plan->practice;
                $group = $plan->group_id;
                $plans[] = $plan;
            }
            foreach($plans as $plan) {
                $plan->theory_main = $theory;
                $plan->practice_main = $practice;
                $plan->save();
            }
        }
        return redirect()->route('plans', ['group' => $group]);
    }
}
