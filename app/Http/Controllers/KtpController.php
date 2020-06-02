<?php

namespace App\Http\Controllers;
use App\Plan;
use App\Subject;
use App\Group;
use App\Cikl;
use App\Teacher;
use App\Lesson;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KtpController extends Controller
{
    public function index()
    {
        $group = \Request::get('group');
        $kurs = \Request::get('kurs');
        $subject = \Request::get('subject');
        $user = \Auth::user();
        $programs = Plan::select('group_id', 'subject_id', 'year', 'subgroup', 'cikl_id', 'teacher_id')
        ->when($group, function($query, $group) {
            $query->where('group_id', $group);
        })
        ->when($kurs, function($query, $kurs) {
            $query->whereIn('semestr', [$kurs * 2, ($kurs * 2 - 1)]);
        })
        ->when($subject, function($query, $subject) {
            $query->where('subject_id', $subject);
        })
        ->when($user->role == 'teacher', function($query) use($user) {
            $query->where('teacher_id', $user->person_id);
        })
        ->groupBy('group_id', 'subject_id', 'year', 'subgroup', 'cikl_id', 'teacher_id')
        ->orderBy('semestr', 'asc')
        ->orderBy('subject_id', 'asc')
        ->orderBy('subgroup', 'asc')->paginate(30);
        return view('ktp.index', [
            'programs' => $programs,
            'groups' => Group::orderBy('name', 'asc')->get(),
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }

    public function view($groupId, $subjectId, $kurs)
    {
        $group = Group::findOrFail($groupId);
        $subject = Subject::findOrFail($subjectId);
        $teacher = Teacher::find(\Request::get('teacher')) ?? new Teacher();
        $data = Plan::where('group_id', $groupId)
        ->where('subject_id', $subjectId)
        ->where('subgroup', \Request::get('subgroup'))
        ->where('cikl_id', \Request::get('cikl'))
        ->whereIn('semestr', [$kurs * 2, ($kurs * 2 - 1)])
        ->orderBy('semestr', 'asc')->get();
        $plans = [];
        $parts = [];
        $can = false;
        foreach($data as $p) {
            if(\Auth::user()->can('update', $p)) $can = true;
            $plans[$p->semestr % 2 ? 1 :2] = $p;
            foreach($p->lessons as $l) {
                $parts[$l->part_id]['part'] = $l->part;
                $parts[$l->part_id]['lessons'][] = $l;
            }
        }
        if(!$can) abort(403);
        return view('ktp.view', [
            'group' => $group,
            'subject' => $subject,
            'teacher' => $teacher,
            'plans' => $plans,
            'parts' => $parts,
            'kurs' => $kurs,
        ]);
    }

    public function export($groupId, $subjectId, $kurs)
    {
        $teacherId = \Request::get('teacher');
        $group = Group::findOrFail($groupId);
        $subject = Subject::findOrFail($subjectId);
        $teacher = Teacher::find($teacherId) ?? new Teacher();
        $query = Plan::where('group_id', $groupId)
        ->where('subject_id', $subjectId)
        ->where('teacher_id', $teacherId)
        ->whereIn('semestr', [$kurs * 2, ($kurs * 2 - 1)]);
        if(Plan::where('group_id', $groupId)
        ->where('subject_id', $subjectId)
        ->where('teacher_id', $teacherId)
        ->whereIn('semestr', [$kurs * 2, ($kurs * 2 - 1)])
        ->where('subgroup', '<>', 2)->exists()) {
            $query->where('subgroup', '<>', 2);
        }
        $data = $query->orderBy('semestr', 'asc')->get();
        $plans = [];
        $parts = [];
        $can = false;
        foreach($data as $p) {
            if(\Auth::user()->can('update', $p)) $can = true;
            $plans[$p->semestr % 2 ? 1 :2] = $p;
            foreach($p->lessons as $l) {
                $parts[$l->part_id]['part'] = $l->part;
                $parts[$l->part_id]['lessons'][] = $l;
            }
        }
        if(!$can) abort(403);
        $roman = ['I', 'II', 'III', 'IV'];
        $phpWord = new \PhpOffice\PhpWord\PHPWord();
        $phpWord->setDefaultFontSize(12);
        $phpWord->setDefaultFontName('Times New Roman');
        $section = $phpWord->addSection(array(
            'marginLeft'   => floor(56.7*30),
            'marginRight'  => floor(56.7*10),
            'marginTop'    => floor(56.7*20),
            'marginBottom' => floor(56.7*20),
        ));

        $center=array('align'=>'center');
        $right=array('align'=>'right');
        $bold=array('bold'=>true);
        $italic=array('italic'=>true);
        $underline=array('underline'=>'single');
        $offset=array('spaceBefore'=>150);
        $styleTable = array('borderSize' => 6, 'borderColor' => '000','unit' => 'pct',
        'width' => 100 * 50);
        $rotate=array('textDirection'=>'btLr');
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan2 = array('gridSpan' => 2, 'valign' => 'center');
        $cellColSpan4 = array('gridSpan' => 4, 'valign' => 'center');
        $cellColSpan8 = array('gridSpan' => 8, 'valign' => 'center');
        $cellColSpan10 = array('gridSpan' => 10, 'valign' => 'center');
        $cellVCentered = array('valign' => 'center');

        $section->addText("Қазақстан Республикасының Білім және ғылым мининстрлігі", array_merge($bold, $italic), $center);
        $section->addText("«Ақпараттық технологиялар колледжі» ШЖҚ КМК", array_merge($bold, $italic), $center);
        $section->addText("Министерство образования и науки Республики Казахстан", array_merge($bold, $italic), $center);
        $section->addText("КГП на ПХВ «Колледж информационных технологий»", array_merge($bold, $italic), $center);
        $section->addTextBreak(1);

        $section->addText("Бекітемін", null);
        $section->addText("Утверждаю", null);
        $section->addText("Басшының ОІ жөнендегі", null);
        $section->addText("орынбасары м.а.", null);
        $section->addText("И.о. зам. руководителя по УР", null);
        $section->addText("_________ Н.Н, Елисеева", null);
        $section->addText(date('Y')." . \"_______\" _________", null);
        $section->addTextBreak(1);

        $section->addText($subject->name_kz, $bold, $center);
        $section->addText("пәнінің күнтізбелік-тақырыптық жоспары", $bold, $center);
        $section->addText(($group->year_create + $kurs - 1).'-'.($group->year_create + $kurs)." оқу жылының I, II семестрі", $bold, $center);
        $section->addTextBreak(1);
        $section->addText("Календарно-тематический план по предмету", $bold, $center);
        $section->addText($subject->name, $bold, $center);
        $section->addText("на I, II семестр ".($group->year_create + $kurs - 1).'-'.($group->year_create + $kurs)." учебного года", $bold, $center);
        $section->addTextBreak(1);

        $textRun=$section->createTextRun();
        $textRun->addText("Оқытушы/Преподавателя     ");
        $textRun->addText($teacher->fullName);
        $textRun->addTextBreak(2);

        $textRun->addText("Курс, группа, специальность ");
        $textRun->addText($roman[$kurs]."курс, гр.".$group->codes[$kurs]." ".$group->specialization->code.' "'.$group->specialization->name.'"');
        $textRun->addTextBreak(1);

        $table=$section->addTable(array('unit' => 'pct', 'width' => 100 * 50));
        $table->addRow();
        $table->addCell(2000)->addText("Пәнге бөлінген жалпы сағат саны Общее количество часов на предмет");
        $table->addCell(2000)->addText((@$plans[1]->theory_main + @$plans[1]->practice_main + @$plans[1]->projectMain) ?? (@$plans[2]->theory_main + @$plans[2]->practice_main + @$plans[2]->projectMain));
        $table->addCell(2000)->addText("о.і. теор. в т.ч. теор.");
        $table->addCell(2000)->addText(@$plans[1]->theory_main ?? @$plans[2]->theory_main);
        $table->addCell(2000)->addText("зерт.тәж. лаб.прак.");
        $table->addCell(2000)->addText(@$plans[1]->practice_main ?? @$plans[2]->practice_main);

        $table->addRow();
        $table->addCell(2000)->addText("Семестр басталғанға дейін берілді Дано до начала семестра");
        $table->addCell(2000)->addText("");
        $table->addCell(2000)->addText("о.і. теор. в т.ч. теор.");
        $table->addCell(2000)->addText("");
        $table->addCell(2000)->addText("зерт.тәж. лаб.прак.");
        $table->addCell(2000)->addText("");

        $table->addRow();
        $table->addCell(2000)->addText("Осы оқу жылына жоспарланды Планируется на текущий уч.год");
        $table->addCell(2000)->addText(@$plans[1]->total + @$plans[2]->total);
        $table->addCell(2000)->addText("о.і. теор. в т.ч. теор.");
        $table->addCell(2000)->addText(@$plans[1]->theory + @$plans[2]->theory);
        $table->addCell(2000)->addText("зерт.тәж. лаб.прак.");
        $table->addCell(2000)->addText(@$plans[1]->lab + @$plans[2]->lab + @$plans[1]->practice + @$plans[2]->practice);

        $table->addRow();
        $table->addCell(2000)->addText("1 семестрге жоспарланып отыр Планируется на 1 семестр");
        $table->addCell(2000)->addText(@$plans[1]->total);
        $table->addCell(2000)->addText("о.і. теор. в т.ч. теор.");
        $table->addCell(2000)->addText(@$plans[1]->theory);
        $table->addCell(2000)->addText("зерт.тәж. лаб.прак.");
        $table->addCell(2000)->addText(@$plans[1]->lab + @$plans[1]->practice);

        $table->addRow();
        $table->addCell(2000)->addText("2 семестрге жоспарланып отыр Планируется на 2 семестр");
        $table->addCell(2000)->addText(@$plans[2]->total);
        $table->addCell(2000)->addText("о.і. теор. в т.ч. теор.");
        $table->addCell(2000)->addText(@$plans[2]->theory);
        $table->addCell(2000)->addText("зерт.тәж. лаб.прак.");
        $table->addCell(2000)->addText(@$plans[2]->lab + @$plans[2]->practice);

        $table->addRow();
        $table->addCell(2000)->addText("I семестр аяғында На конец 1 семестра");
        $end1 = @$plans[1]->is_zachet ? 'зачёт' : '';
        $end1 = @$plans[1]->is_exam ? 'экзамен' : '';
        $table->addCell(2000)->addText($end1);
        $table->addCell(2000, $cellColSpan4)->addText("");
        $table->addRow();
        $table->addCell(2000)->addText("II семестр аяғында На конец 2 семестра");
        $end2 = @$plans[2]->is_zachet ? 'зачёт' : '';
        $end2 = @$plans[2]->is_exam ? 'экзамен' : '';
        $table->addCell(2000)->addText($end2);
        $table->addCell(2000, $cellColSpan4)->addText("");


        $sectionH = $phpWord->addSection(array(
            'orientation'=>'landscape',
            'marginLeft'   => floor(56.7*30),
            'marginRight'  => floor(56.7*10),
            'marginTop'    => floor(56.7*20),
            'marginBottom' => floor(56.7*20),
        ));   
        $table=$sectionH->addTable($styleTable);
        $table->addRow();
        $table->addCell(2000, array_merge($rotate, $cellRowSpan))->addText("Сабақтың реттік №\nПорядковый № урока", null, $center);
        $table->addCell(2000, array_merge($rotate, $cellRowSpan))->addText("Бөлімдер мен тақырыптардың аттары\nНаименование разделов и тем", null, $center);
        $table->addCell(2000, $cellColSpan2)->addText("Сағат саны Кол-во часов", null, $center);
        $table->addCell(2000, array_merge($rotate, $cellRowSpan))->addText("Оқудың күнтізбелік мерзімдері\nКалендарные сроки", null, $center);
        $table->addCell(2000, array_merge($rotate, $cellRowSpan))->addText("Оқу тұрпаты және түрі\nТип и вид занятия", null, $center);
        $table->addCell(2000, array_merge($rotate, $cellRowSpan))->addText("Пәнаралық байланыс\nМежпредметные связи", null, $center);
        $table->addCell(2000, array_merge($rotate, $cellRowSpan))->addText("Көрнекі оқу мен техникалық құралдар\nУчебные, наглядные пособия и ТСО", null, $center);
        $table->addCell(2000, array_merge($rotate, $cellRowSpan))->addText("Өздік жұмысының түрі\nВид самостоятельной работы", null, $center);
        $table->addCell(2000, array_merge($rotate, $cellRowSpan))->addText("Негізгі және қосымша әдебиеттер көрсетілген үй тапсырмасы\nДом. задание с указанием основной и дополнительной литературы", null, $center);
        $table->addRow();
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(2000)->addText("теор.", null, $center);
        $table->addCell(2000)->addText("практ.", null, $center);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $num=0;
        $total = $labPrac= 0;
        foreach ($parts as $key => $part) {
            $table->addRow();
            $table->addCell(2000, $cellColSpan10)->addText($part['part']->name);
            foreach($part['lessons'] as $l) {
                $table->addRow();
                $table->addCell(2000)->addText(++$num);
                $table->addCell(2000)->addText($l->topic);
                $table->addCell(2000)->addText($l->total - $l->practice ? $l->total - $l->practice : '');
                $table->addCell(2000)->addText($l->practice);
                $table->addCell(2000)->addText($l->date ? date('d.m.Y', strtotime($l->date)) : '');
                $table->addCell(2000)->addText($l->practice?'Лабораторно-практическое занятие':'Комбинированная лекция с элементами беседы');
                $table->addCell(2000)->addText();
                $table->addCell(2000)->addText();
                $table->addCell(2000)->addText();
                $table->addCell(2000)->addText();
                $total += $l->total;
                $labPrac += $l->practice;
            }
        }
        $table->addRow();
        $table->addCell(2000)->addText("");
        $table->addCell(2000)->addText("Всего");
        $table->addCell(2000)->addText($total);
        $table->addCell(2000)->addText($labPrac);
        $table->addCell(2000)->addText("");
        $table->addCell(2000)->addText("");
        $table->addCell(2000)->addText("");
        $table->addCell(2000)->addText("");
        $table->addCell(2000)->addText("");
        $table->addCell(2000)->addText("");

        $sectionV = $phpWord->addSection(array(
            'marginLeft'   => floor(56.7*30),
            'marginRight'  => floor(56.7*10),
            'marginTop'    => floor(56.7*20),
            'marginBottom' => floor(56.7*20),
        ));   

        $sectionV->addText("Комплект методического обеспечения", $bold, $center);
        $sectionV->addText("Әдістемелік қамтамасыздандыру комплектісі", $bold, $center);
        $sectionV->addTextBreak(1);

        $sectionV->addText("Приложение 1", $bold, $right);
        $sectionV->addTextBreak(1);

        $sectionV->addText("Негізгі әдебиет", $bold, $center);
        $sectionV->addText("Основная литература", $bold, $center);
        $sectionV->addTextBreak(1);

        $sectionV->addText("Қосымша әдебиет", $bold, $center);
        $sectionV->addText("Дополнительная литература", $bold, $center);
        $sectionV->addTextBreak(1);

        $sectionV->addText("Приложение 2", $bold, $right);
        $sectionV->addTextBreak(1);

        $sectionV->addText("Нұсқаулық карталар", $bold, $center);
        $sectionV->addText("Инструкционные карты к выполнению лабораторно-практических работ", $bold, $center);
        $sectionV->addPageBreak();

        $sectionV->addText("Приложение 3", $bold, $right);
        $sectionV->addTextBreak(1);

        $sectionV->addText("Көрнекі құралдар", $bold, $center);
        $sectionV->addText("Наглядные пособия", $bold, $center);
        $sectionV->addPageBreak();

        $sectionV->addText("Приложение 4", $bold, $right);
        $sectionV->addTextBreak(1);

        $sectionV->addText("Пәнаралық байланыс", $bold, $center);
        $sectionV->addText("Межпредметные связи", $bold, $center);
       
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
 
        header('Content-Disposition: inline; filename="КТП '.$group->codes[$kurs].' '.$subject->name.'.docx"');
        header('Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $objWriter->save('php://output');
    }
}
