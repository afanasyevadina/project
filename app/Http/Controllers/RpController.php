<?php

namespace App\Http\Controllers;
use App\Plan;
use App\Subject;
use App\Group;
use App\Cikl;
use App\Teacher;
use App\Part;
use App\Lesson;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RpController extends Controller
{
    public function index()
    {
        $group = \Request::get('group');
        $subject = \Request::get('subject');
        $user = \Auth::user();
        $programs = Plan::select('group_id', 'subject_id', 'cikl_id')     
        ->when($group, function($query, $group) {
            $query->where('group_id', $group);
        })
        ->when($subject, function($query, $subject) {
            $query->where('subject_id', $subject);
        })
        ->when($user->role == 'teacher', function($query) use($user) {
            $query->where('teacher_id', $user->person_id);
        })
        ->groupBy('group_id', 'subject_id', 'cikl_id')->paginate(30);
        return view('rp.index', [
            'programs' => $programs,
            'groups' => Group::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get()
        ]);
    }

    public function view($groupId, $subjectId)
    {
        $group = Group::where('id', $groupId)->with('specialization')->first();
        $subject = Subject::findOrFail($subjectId);
        $plans = Plan::where('group_id', $groupId)->with('lessons.part')
        ->where('subject_id', $subjectId)
        ->where('subgroup', '<>', 2)
        ->where('cikl_id', \Request::get('cikl'))
        ->orderBy('semestr', 'asc')->get();
        $groups =  Plan::select('group_id', 'subject_id')->where('subject_id', $subjectId)
        ->where('group_id', '<>', $groupId)
        ->where('subgroup', '<>', 2)
        ->where('cikl_id', \Request::get('cikl'))
        ->has('lessons')
        ->orderBy('semestr', 'asc')->distinct()->get();
        return view('rp.view', [
            'group' => $group,
            'groups' => $groups,
            'subject' => $subject,
            'plans' => $plans,
            'teacher' => $plans[0]->teacher->fullName,
        ]);
    }

    public function store(Request $request, $groupId, $subjectId)
    {
        $subject = Subject::find($subjectId);
        $data = Plan::where('group_id', $groupId)
        ->where('subject_id', $subjectId)
        ->where('cikl_id', \Request::get('cikl'))
        ->orderBy('semestr', 'asc')->get();
        $main = $parallel = [];
        foreach($data as $key => $plan) {
            foreach($plan->lessons as $les) {
                if($plan->theory) $les->practice = null;
                if($plan->subgroup ==2) $parallel[] = $les;
                else $main[] = $les;
            }
        }
        $parts = $request->parts;
        Part::whereIn('id', $request->deleted)->delete();
        $order = $paralOrder = 0;
        foreach ($parts as $key => $p) {
            $part = isset($p['id']) ? Part::find($p['id']) : new Part();
            $part->name = $p['name'];
            $part->save();
            foreach ($p['lessons'] as $k => $l) {
                @$main[$order]->topic = $l['topic'];
                @$main[$order]->total = $l['total'];
                @$main[$order]->practice = $l['practice'];
                @$main[$order]->part_id = $part->id;
                @$main[$order]->order = $order + 1;
                if(
                    ($l['practice'] || $subject->divide == 1) && 
                    @$parallel[$paralOrder]->plan->semestr == @$main[$order]->plan->semestr
                ) {
                    @$main[$order]->subgroup = $main[$order]->plan->subgroup;
                    @$parallel[$paralOrder]->topic = $l['topic'];
                    @$parallel[$paralOrder]->total = $l['total'];
                    @$parallel[$paralOrder]->practice = $l['practice'];
                    @$parallel[$paralOrder]->part_id = $part->id;
                    @$parallel[$paralOrder]->order = $order + 1;
                    @$parallel[$paralOrder]->subgroup = $parallel[$paralOrder]->plan->subgroup;
                    @$parallel[$paralOrder]->save();
                    $paralOrder ++;
                }
                @$main[$order]->save();
                $order ++;
            }
        }
        $stop = $order;
        while(isset($main[$order])) {
            $main[$order]->part_id = null;
            @$main[$order]->order = $order + 1;
            $main[$order]->save();
            $order ++;
        }
        $order = $stop;
        while(isset($parallel[$paralOrder])) {
            $parallel[$paralOrder]->part_id = null;
            @$parallel[$paralOrder]->order = $order + 1;
            $parallel[$paralOrder]->save();
            $paralOrder ++;
        }
    }

    public function copy($groupId, $subjectId)
    {
        $source = Plan::where('group_id', $groupId)
        ->where('subject_id', $subjectId)
        ->where('subgroup', '<>', 2)
        ->where('cikl_id', \Request::get('cikl'))
        ->orderBy('semestr', 'asc')->get()->keyBy('semestr');
        $destination = Plan::where('group_id', \Request::get('to'))
        ->where('subject_id', $subjectId)
        ->where('cikl_id', \Request::get('cikl'))
        ->orderBy('semestr', 'asc')->get();
        $usedParts = [];
        foreach ($destination as $plan) {
            $index = 0;
            $lpr = $plan->lab + $plan->practice + $plan->project;
            $lprGiven = 0;
            foreach ($plan->lessons as $key => $lesson) {
                if(!isset($source[$plan->semestr]->lessons[$index])) continue;
                $srcLesson = $source[$plan->semestr]->lessons[$index];
                if($plan->subgroup <> 2 || $plan->subject->divide == 1 || $srcLesson->practice) {
                    if($lpr > $lprGiven) {
                        $lesson->practice = $srcLesson->practice;
                    }
                    $lesson->part()->delete();
                    if(!isset($usedParts[$srcLesson->part_id])) {
                        $part = Part::create(['name' => $srcLesson->part->name]);
                        $usedParts[$srcLesson->part_id] = $part->id;
                    }
                    $lesson->part_id = $usedParts[$srcLesson->part_id];
                    $lesson->topic = $srcLesson->topic;
                    $lesson->save();
                    $lprGiven += $srcLesson->practice;
                }
                $index++;
            }
        }
    }

    public function reset($groupId, $subjectId)
    {
        $plans = Plan::where('group_id', $groupId)
        ->where('subject_id', $subjectId)
        ->where('cikl_id', \Request::get('cikl'))
        ->orderBy('semestr', 'asc')->get();
        foreach ($plans as $key => $plan) {
            foreach ($plan->lessons as $key => $lesson) {
                $lesson->part()->delete();
                $lesson->part_id = null;
                $lesson->topic = null;
                $lesson->practice = null;
                $lesson->save();
            }
        }
    }

    public function export($groupId, $subjectId)
    {
        $group = Group::where('id', $groupId)->with('specialization')->first();
        $subject = Subject::findOrFail($subjectId);
        $data = Plan::where('group_id', $groupId)->with('lessons.part')
        ->where('subject_id', $subjectId)
        ->where('cikl_id', \Request::get('cikl'))
        ->where('subgroup', '<>', 2)
        ->orderBy('semestr', 'asc')->get();
        $years = [];
        $total = $labPrac = 0;
        $parts = [];
        foreach($data as $p) {
            $total += $p->total;
            $labPrac += $p->lab;
            $labPrac += $p->practice;
            $labPrac += $p->project;
            $years[$p->year][$p->semestr % 2 ? 1 : 2] = $p;
            foreach($p->lessons as $l) {
                if($l->part_id) {
                    $parts[$l->part_id]['part'] = $l->part;
                    $parts[$l->part_id]['lessons'][] = $l;
                }
            }
        }
        $roman = ['I', 'II', 'III', 'IV'];
        $phpWord = new \PhpOffice\PhpWord\PHPWord();
        $phpWord->setDefaultFontSize(13);
        $phpWord->setDefaultFontName('Times New Roman');
        $section = $phpWord->addSection(array(
            'marginLeft'   => floor(56.7*30),
            'marginRight'  => floor(56.7*10),
            'marginTop'    => floor(56.7*20),
            'marginBottom' => floor(56.7*20),
        ));   

        $center=array('align'=>'center');
        $bold=array('bold'=>true);
        $size12=array('size'=>12);
        $underline=array('underline'=>'single');
        $offset=array('spaceBefore'=>150);
        $styleTable = array('borderSize' => 6, 'borderColor' => '000','unit' => 'pct', 'width' => 100 * 50);
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan2 = array('gridSpan' => 2, 'valign' => 'center');
        $cellColSpan4 = array('gridSpan' => 4, 'valign' => 'center');
        $cellColSpan8 = array('gridSpan' => 8, 'valign' => 'center');
        $cellVCentered = array('valign' => 'center');

        $section->addText("Қазақстан Республикасының Білім және ғылым мининстрлігі", $bold, $center);
        $section->addText("\"Павлодар бизнес-колледжі\" КМҚК", $bold, $center);
        $section->addText("Министерство образования и науки Республики Казахстан", $bold, $center);
        $section->addText("КГКП \"Павлодарский бизнес-колледж\"", $bold, $center);
        $section->addTextBreak(1);

        $section->addText("Бекітемін", null);
        $section->addText("Утверждаю", null);
        $section->addText("Басшының ОІ жөнендегі", null);
        $section->addText("орынбасары м.а.", null);
        $section->addText("И.о. зам. руководителя по УР", null);
        $section->addText("_________ Н.Н, Елисеева", null);
        $section->addText(date('Y')." . \"_______\" _________", null);
        $section->addTextBreak(1);

        $section->addText("Оқу жұмыс бағдарламасы", $bold, $center);
        $section->addText("Рабочая учебная программа", $bold, $center);
        $section->addTextBreak(1);

        $textRun=$section->createTextRun();
        $textRun->addText("Оқытушы/Преподавателя   ");
        $textRun->addText($data[0]->teacher->fullName, $underline);
        $textRun->addTextBreak(2);

        $textRun->addText('"'.$subject->name_kz.'"', $underline);
        $textRun->addText(" пәні бойынша жұмыс бағдарламасы типтік бағдарлама 2015 ж. \"24\" тамыз тіркеу №4209 негізінде құрастырылған.");
        $textRun->addTextBreak(1);
        $textRun->addText("Рабочая программа разработана на основании типовой программы по дисциплине ");
        $textRun->addText('"'.$subject->name.'"', $underline);
        $textRun->addText(" регистрационный №4209 от \"24\" августа 2015 г.");
        $section->addTextBreak(1);

        $section->addText($group->specialization->code.' "'.$group->specialization->name_kz.'" мамандығы үшін');
        $section->addText('Для специальности '.$group->specialization->code.' "'.$group->specialization->name);
        $section->addTextBreak(1);

        $section->addText("Оқыту сағаттарын бөлу", null, $center);
        $section->addText("Распределение учебного времени", null, $center);       

        $table = $section->addTable($styleTable);
        $table->addRow(null, array('tblHeader' => true));
        $table->addCell(2000, $cellRowSpan)->addText('Курс', $size12);
        $table->addCell(2000, $cellRowSpan)->addText('Барлық сағат/Всего часов', $size12);
        $table->addCell(2000, $cellColSpan8)->addText('Оның ішінде/из них', $size12, $center);

        $table->addRow();
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(2000, $cellColSpan2)->addText('Теориялық сабақ/теоретических занятий', $size12, $center);
        $table->addCell(2000, $cellColSpan2)->addText('Зертхана жұмысы/ лабораторные работы', $size12, $center);
        $table->addCell(2000, $cellColSpan2)->addText('Тәжірибе сабағы/ практические занятия', $size12, $center);
        $table->addCell(2000, $cellColSpan2)->addText('Курстық жұмыстар/ курсовых работ', $size12, $center);

        $table->addRow();
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(2000)->addText('Сем. №1', $size12, $center);
        $table->addCell(2000)->addText('Сем. №2', $size12, $center);
        $table->addCell(2000)->addText('Сем. №1', $size12, $center);
        $table->addCell(2000)->addText('Сем. №2', $size12, $center);
        $table->addCell(2000)->addText('Сем. №1', $size12, $center);
        $table->addCell(2000)->addText('Сем. №2', $size12, $center);
        $table->addCell(2000)->addText('Сем. №1', $size12, $center);
        $table->addCell(2000)->addText('Сем. №2', $size12, $center);
        foreach ($years as $key => $y) {
            $table->addRow();
            $table->addCell(2000)->addText($roman[$key - $group->year_create], $size12, $center);
            $table->addCell(2000)->addText(@$y[1]->total + @$y[2]->total, $size12, $center);
            $table->addCell(2000)->addText(@$y[1]->theory, $size12, $center);
            $table->addCell(2000)->addText(@$y[2]->theory, $size12, $center);
            $table->addCell(2000)->addText(@$y[1]->lab, $size12, $center);
            $table->addCell(2000)->addText(@$y[2]->lab, $size12, $center);
            $table->addCell(2000)->addText(@$y[1]->practice, $size12, $center);
            $table->addCell(2000)->addText(@$y[2]->practice, $size12, $center);
            $table->addCell(2000)->addText(@$y[1]->project, $size12, $center);
            $table->addCell(2000)->addText(@$y[2]->project, $size12, $center);
        }
        $section->addTextBreak(1);

        $section->addText("Топтарда оқылатын пән", null, $center);
        $section->addText("Предмет изучается в группах", null, $center);
        $table = $section->addTable($styleTable);
        $table->addRow();
        $table->addCell(2000)->addText("Оқу жылы/учебный год", $size12);
        $table->addCell(2000)->addText("Курстың нөмірі/номер курса", $size12);
        $table->addCell(2000)->addText("Топтың шифрі/шифр группы", $size12);
        foreach ($years as $key => $y) { 
            $table->addRow();
            $table->addCell(2000)->addText($key.'-'.($key + 1), $size12, $center);
            $table->addCell(2000)->addText($roman[$key - $group->year_create], $size12, $center);
            $table->addCell(2000)->addText($group->codes[$key - $group->year_create + 1], $size12, $center);
        }

        $section->addPageBreak();

        $section->addText("СТРУКТУРА РАБОЧЕЙ ПРОГРАММЫ", $bold, $center);
        $section->addPageBreak();
        $section->addText("ПОЯСНИТЕЛЬНАЯ ЗАПИСКА", $bold, $center);
        $section->addPageBreak();

        $section->addText("2. ТЕМАТИЧЕСКИЙ ПЛАН", $bold, $center);
        $section->addTextBreak(1);

        $table = $section->addTable($styleTable);
        $table->addRow();
        $table->addCell(2000, $cellRowSpan)->addText("№ п/п", array_merge($bold, $size12), $center);
        $table->addCell(2000, $cellRowSpan)->addText("Наименование разделов и тем", array_merge($bold, $size12), $center);
        $table->addCell(2000, $cellColSpan2)->addText("Количество учебного времени", array_merge($bold, $size12), $center);
        $table->addRow();
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(2000)->addText("всего", array_merge($bold, $size12), $center);
        $table->addCell(2000)->addText("лпз", array_merge($bold, $size12), $center);

        foreach ($parts as $key => $part) {       
            $table->addRow();
            $table->addCell(2000, $cellColSpan4)->addText($part['part']->name, array_merge($bold, $size12), $center);
            foreach($part['lessons'] as $l) {       
                $table->addRow();
                $table->addCell(2000)->addText($l->order, $size12, $center);
                $table->addCell(2000)->addText($l->topic, $size12, $center);
                $table->addCell(2000)->addText($l->total ? $l->total : '', $size12, $center);
                $table->addCell(2000)->addText($l->practice ? $l->practice : '', $size12, $center);
            }
        }
        $table->addRow();
        $table->addCell(2000)->addText("");
        $table->addCell(2000)->addText("Всего учебного времени по дисциплине");
        $table->addCell(2000)->addText($total);
        $table->addCell(2000)->addText($labPrac);

        $section->addPageBreak();

        $section->addText("СОДЕРЖАНИЕ УЧЕБНОЙ ПРОГРАММЫ",  $bold, $center);
        $section->addTextBreak(1);
        $partNum = 0;
        foreach ($parts as $key => $part) { 
            $lesNum = 0;
            $section->addText($part['part']->name, $bold, $center);
            foreach($part['lessons'] as $l) {   
                $section->addText("Тема ".++$partNum.".".++$lesNum.". ".$l->topic, null,
                    array(
                        'indentation' => array('left' => floor(56.7*12.5))
                    )
                );
            }
            $section->addTextBreak(2);
        }

        $sectionH = $phpWord->addSection(array(
            'orientation'=>'landscape',
            'marginLeft'   => floor(56.7*30),
            'marginRight'  => floor(56.7*10),
            'marginTop'    => floor(56.7*20),
            'marginBottom' => floor(56.7*20),
        ));   
        $table=$sectionH->addTable($styleTable);
        $table->addRow(null, array('tblHeader' => true));
        $table->addCell(2000, $cellRowSpan)->addText("№", $size12, $center);
        $table->addCell(2000, $cellRowSpan)->addText("Кол-во часов", $size12, $center);
        $table->addCell(2000, $cellRowSpan)->addText("Основные вопросы, темы", $size12, $center);
        $table->addCell(2000, $cellColSpan4)->addText("Цель дидактического процесса", array_merge($bold, $size12), $center);
        $table->addCell(2000, $cellRowSpan)->addText("Состав методического комплекса", $size12, $center);
        $table->addRow(null, array('tblHeader' => true));
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(2000)->addText("представления", $size12, $center);
        $table->addCell(2000)->addText("знания", $size12, $center);
        $table->addCell(2000)->addText("умения", $size12, $center);
        $table->addCell(2000)->addText("навыки", $size12, $center);
        $table->addCell(null, $cellRowContinue);
        $partNum = 0;
        foreach ($parts as $part) {
            $table->addRow();
            $table->addCell(2000)->addText(++$partNum);
            $table->addCell(2000)
            ->addText(array_reduce($part['lessons'], function($sum, $l) { return $sum += $l->total;}, 0));
            $table->addCell(2000)->addText($part['part']->name);
            $table->addCell(2000)->addText('');
            $table->addCell(2000)->addText('');
            $table->addCell(2000)->addText('');
            $table->addCell(2000)->addText('');
            $table->addCell(2000)->addText('');
        }

        $sectionV = $phpWord->addSection(array(
            'marginLeft'   => floor(56.7*30),
            'marginRight'  => floor(56.7*10),
            'marginTop'    => floor(56.7*20),
            'marginBottom' => floor(56.7*20),
        ));   
        $sectionV->addText("5. ПЕРЕЧЕНЬ ЛАБОРАТОРНО-ПРАКТИЧЕСКИХ РАБОТ", $bold, $center);

        $table=$sectionV->addTable($styleTable);
        $table->addRow(null, array('tblHeader' => true));
        $table->addCell(2000)->addText("№ занятия. Наименование темы", array_merge($bold, $size12), $center);
        $table->addCell(2000)->addText("Кол-во часов", array_merge($bold, $size12), $center);
        $table->addCell(2000)->addText("Содержание лабораторной работы", array_merge($bold, $size12), $center);
        foreach($parts as $part) {
            foreach($part['lessons'] as $l) {
                if($l->practice) {
                    $table->addRow();
                    $table->addCell(2000)->addText("№".$l->order." ".$l->topic);
                    $table->addCell(2000)->addText($l->practice, $bold);
                    $table->addCell(2000)->addText('');
                }
            }
        }
        $table->addRow();
        $table->addCell(2000)->addText("Всего:", $bold);
        $table->addCell(2000)->addText($labPrac, $bold);
        $table->addCell(2000)->addText("");
        $sectionV->addPageBreak();
        $sectionV->addText("6. Контрольные вопросы", $bold, $center);
        $sectionV->addPageBreak();
        $sectionV->addText("7. ЛИТЕРАТУРА", $bold, $center);

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        header('Content-Disposition: inline; filename="РП '.$group->name.' '.$subject->name.'.docx"');
        header('Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $objWriter->save('php://output');
    }
}
