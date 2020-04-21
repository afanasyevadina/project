<?php

namespace App\Http\Controllers;
use App\Plan;
use App\Subject;
use App\Group;
use App\Cikl;
use App\Lesson;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class PlanController extends Controller
{
    public function index()
    {
        $groupId = \Request::get('group');
        $all = Plan::where('group_id', $groupId)
        ->where('subgroup', '<>', 2)->get();
        $plans = [];
        foreach ($all as $key => $p) {
            if(!isset($plans[$p->cikl_id]))
                $plans[$p->cikl_id]['cikl'] = $p->cikl;
            $plans[$p->cikl_id]['subjects'][$p->subject_id]['details'][] = $p;
            $plans[$p->cikl_id]['subjects'][$p->subject_id]['shifr'] = $p->shifr;
            $plans[$p->cikl_id]['subjects'][$p->subject_id]['subject'] = $p->subject;
            @$plans[$p->cikl_id]['subjects'][$p->subject_id]['control'] += $p->controls;
            $plans[$p->cikl_id]['subjects'][$p->subject_id]['theory'] = $p->theoryMain;
            $plans[$p->cikl_id]['subjects'][$p->subject_id]['practice'] = $p->practiceMain;
            $plans[$p->cikl_id]['subjects'][$p->subject_id]['project'] = $p->projectMain;
            $plans[$p->cikl_id]['subjects'][$p->subject_id]['sem'.$p->semestr] = $p->total;
            if($p->is_project) {
                $plans[$p->cikl_id]['subjects'][$p->subject_id]['project_sem'] = $p->semestr;
            }
            if($p->is_exam)
                $plans[$p->cikl_id]['subjects'][$p->subject_id]['exam_sem'] = $p->semestr;
            if($p->is_zachet)
                $plans[$p->cikl_id]['subjects'][$p->subject_id]['zachet_sem'][] = $p->semestr;
        }
        $available = Plan::select('group_id')
        ->where('group_id', '<>', $groupId)
        ->distinct()->get();
        return view('plan.index', [
            'plans' => $plans,
            'available' => $available,
            'groups' => Group::orderBy('name', 'asc')->get(),
            'subjects' => Subject::orderBy('name', 'asc')->get(),
            'cikls' => Cikl::orderBy('name', 'asc')->get(),
        ]);
    }

    public function upload(Request $request)
    {
        $fileName = Storage::disk('public')->putFile('files', $request->file('file'));
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('public/storage/'.$fileName);
        $sheet = $spreadsheet->getActiveSheet();
        $list = $sheet->toArray();
        //$list = array_slice($list, 8);
        $cikls = $subjects = [];
        foreach (Cikl::all() as $c) 
            $cikls[trim($c->name)] = $c->id;
        foreach (Subject::all() as $s) 
            $subjects[trim($s->name)] = $s->id;
        $group = Group::findOrFail($request->group);

        $cikl = 1;
        $shifr = '';
        $unexpected = [];

        foreach ($list as $key => $row) {
            if(trim(mb_strtolower($row[1])) == 'итого')
                continue;
            $txtCikl = trim(mb_strtolower(trim($row[1])), ':');
            if(isset($cikls[$txtCikl])) {
                $cikl = $cikls[$txtCikl];
                continue;
            }
            if(!isset($subjects[trim($row[1])])) {
                $unexpected[] = $row[1];
                continue;
            }
            if($row[0]) $shifr = $row[0];
            $control = $row[5];
            $theory = $row[7];
            $practice = $row[8];
            for($i = 10; $i < 18; $i++) {
                if($row[$i]) {
                    $semestr = $i - 9;
                    $year = $group->year_create + ceil($semestr / 2) - 1;
                    $total = $row[$i];
                    $plan = Plan::updateOrCreate([
                        'group_id' => $group->id,
                        'semestr' => $semestr,
                        'year' => $year,
                        'cikl_id' => $cikl,
                        'subject_id' => $subjects[trim($row[1])]
                    ], 
                    [
                        'shifr' => $row[0],
                        'total' => $total,
                    ]
                );
                    if($row[2] == $semestr) {
                        $plan->is_exam = 1;
                        $plan->exam = 3;
                        $plan->consul = 2;
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
                    $plan->shifr = $shifr;
                    $plan->shifr_kz = $shifr;
                    $plan->save();
                }
            }
        }
        if(count($unexpected)) Session::flash('errors', $unexpected);
        return redirect()->route('plans', ['group' => $request->group]);
    }

    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);
        $graphic = $plan->group->graphics()->where('year', $plan->year)->first();
        $all = Plan::where('group_id', $plan->group_id)
        ->where('semestr', $plan->semestr)
        ->where('cikl_id', $plan->cikl_id)
        ->where('subject_id', $plan->subject_id)->get();
        foreach($all as $one) {
            $one->fill($request->all());
            $one->total = $one->theory+$one->practice+$one->lab+$one->project;
            if($one->subgroup == 2) {
                if($one->subject->divide == 2) {
                    $one->total -= $one->theory;
                    $one->theory = 0;
                }
                $one->exam = null;
                $one->is_exam = null;
                $one->consul = null;
            }
            if(!empty($graphic) && !in_array($one->cikl_id, [6, 7, 9])) {
                $one->weeks = $one->semestr % 2 ? $graphic->teor1 : $graphic->teor2;
            }
            $one->save();
        }
    }

    public function reset($group)
    {
        Plan::where('group_id', $group)->delete();
        return redirect()->route('plans');
    }

    public function copy()
    {
        $from = \Request::get('from');
        $to = \Request::get('to');
        $dst = Group::findOrFail($to);
        $divide = $dst->students()->count() >= 25;
        $plans = Plan::where('group_id', $from)->get();
        Plan::where('group_id', $to)->delete();
        foreach($plans as $plan) {
            if($plan->subgroup != 2 || $divide) {
                $new = new Plan();
                $new->fill($plan->toArray());
                $new->group_id = $to;
                $new->subgroup = 0;
                $new->year = $dst->year_create + ceil($plan->semestr / 2) - 1;
                $new->save();
            }
        }
        return redirect()->route('plans', ['group' => $to]);
    }

    public function store(Request $request)
    {
        $plan = new Plan();
        $plan->fill($request->all());
        $plan->year = $plan->group->year_create + ceil($plan->semestr / 2) - 1;
        $graphic = $plan->group->graphics()->where('year', $plan->year)->first();
        if(!empty($graphic) && !in_array($plan->cikl_id, [6, 7, 9])) {
            $plan->weeks = $plan->semestr % 2 ? $graphic->teor1 : $graphic->teor2;
        }
        $plan->save();
    }

    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
    }
}
