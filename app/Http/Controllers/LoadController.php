<?php

namespace App\Http\Controllers;
use App\Plan;
use App\Subject;
use App\Group;
use App\Cikl;
use App\Teacher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LoadController extends Controller
{
    public function index()
    {
        $year = \Request::get('year') ?? date('Y');
        $id = \Request::get('teacher');
        if(\Auth::user()->role == 'teacher') $id = \Auth::user()->person_id;
        $teacher = Teacher::findOrFail($id);
        $all = Plan::where('teacher_id', $id)
        ->where('year', $year)
        ->orderBy('cikl_id', 'asc')
        ->orderBy('subject_id', 'asc')->get();
        $plans = [];
        foreach ($all as $key => $p) {
            $sem = $p->semestr % 2 ? 1 : 2;
            $index = $p->group_id.$p->subgroup;
            $plans[$index]['group'] = $p->group;
            $plans[$index]['subject'] = $p->subject;
            @$plans[$index]['control'] += $p->controls;
            $plans[$index]['theory_main'] = $p->theoryMain;
            $plans[$index]['practice_main'] = $p->practiceMain + $p->projectMain;
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
                $plans[$index]['zachet_sem'][$p->semestr] = $p->semestr;
        }
        
        return view('load.index', [
            'plans' => $plans,
            'teacher' => $teacher,
            'year' => $year,
            'teachers' => Teacher::all()
        ]);
    }

    public function export($id, $year)
    {
        $teacher = Teacher::findOrFail($id);
        $all = Plan::where('teacher_id', $id)
        ->where('year', $year)
        ->orderBy('cikl_id', 'asc')
        ->orderBy('subject_id', 'asc')->get();
        $plans = [];
        foreach ($all as $key => $p) {
            $sem = $p->semestr % 2 ? 1 : 2;
            $index = $p->subject_id.$p->subgroup;
            $plans[$index]['group'] = $p->group;
            $plans[$index]['subject'] = $p->subject;
            @$plans[$index]['control'] += $p->controls;
            $plans[$index]['theory_main'] = $p->theoryMain;
            $plans[$index]['practice_main'] = $p->practiceMain + $p->projectMain;
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
                $plans[$index]['zachet_sem'][$p->semestr] = $p->semestr;
        }
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->SetCellValue('A1', 'группа');
        $sheet->SetCellValue('B1', 'преподаватели');
        $sheet->SetCellValue('C1', 'Наименование предмета');
        $sheet->SetCellValue('D1', 'Распределение по семестрам');
        $sheet->SetCellValue('G1', 'Контрольные работы');
        $sheet->SetCellValue('H1', 'По РУП');
        $sheet->SetCellValue('K1', 'Всего часов на учебный год');
        $sheet->SetCellValue('L1', 'Снятие на ПД');
        $sheet->SetCellValue('M1', 'из них теоретических');
        $sheet->SetCellValue('N1', 'из них ЛПР');
        $sheet->SetCellValue('O1', 'Из них курсовые работы');
        $sheet->SetCellValue('P1', '1 семестр');
        $sheet->SetCellValue('S1', '2 семестр');
        $sheet->SetCellValue('V1', 'Консультации');
        $sheet->SetCellValue('W1', 'Экзамены');
        $sheet->SetCellValue('X1', 'Всего за год');
        $sheet->SetCellValue('Y1', 'кол-во уч-ся ХР');
        $sheet->SetCellValue('Z1', 'кол-во часов ХР');
        $sheet->SetCellValue('AA1', 'всего часов МБ');
        $sheet->SetCellValue('D2', 'экзамены');
        $sheet->SetCellValue('E2', 'зачеты');
        $sheet->SetCellValue('F2', 'Курсовые работы');
        $sheet->SetCellValue('H2', 'всего по РУП');
        $sheet->SetCellValue('I2', 'теоретические занятия');
        $sheet->SetCellValue('J2', 'лабораторно-практ. занятия');
        $sheet->SetCellValue('P2', 'Количество нед.');
        $sheet->SetCellValue('Q2', 'часов в нед.');
        $sheet->SetCellValue('R2', 'часов в семестр');
        $sheet->SetCellValue('S2', 'Количество нед.');
        $sheet->SetCellValue('T2', 'часов в нед.');
        $sheet->SetCellValue('U2', 'часов в семестр');
        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:C2');
        $sheet->mergeCells('D1:F1');
        $sheet->mergeCells('G1:G2');
        $sheet->mergeCells('H1:J1');
        $sheet->mergeCells('K1:K2');
        $sheet->mergeCells('L1:L2');
        $sheet->mergeCells('M1:M2');
        $sheet->mergeCells('N1:N2');
        $sheet->mergeCells('O1:O2');
        $sheet->mergeCells('P1:R1');
        $sheet->mergeCells('S1:U1');
        $sheet->mergeCells('V1:V2');
        $sheet->mergeCells('W1:W2');
        $sheet->mergeCells('X1:X2');
        $sheet->mergeCells('Y1:Y2');
        $sheet->mergeCells('Z1:Z2');
        $sheet->mergeCells('AA1:AA2');
        $sheet->getStyle('D2:F2')->getAlignment()->setTextRotation(90); 
        $sheet->getStyle('G1')->getAlignment()->setTextRotation(90); 
        $sheet->getStyle('H2:J2')->getAlignment()->setTextRotation(90);
        $sheet->getStyle('K1:O1')->getAlignment()->setTextRotation(90);
        $sheet->getStyle('P2:U2')->getAlignment()->setTextRotation(90);
        $sheet->getStyle('V1:X1')->getAlignment()->setTextRotation(90); 
        $sheet->getStyle('Y2:AA2')->getAlignment()->setWrapText(true);

        $rowCount = 2; 
        foreach($plans as $p) {
            $rowCount++;
            $sheet->SetCellValue('A'.$rowCount, $p['group']->name);
            $sheet->SetCellValue('B'.$rowCount, $teacher->shortName);
            $sheet->SetCellValue('C'.$rowCount, $p['subject']->name);
            $sheet->SetCellValue('D'.$rowCount, @$p['exam_sem']);
            $sheet->SetCellValue('E'.$rowCount, @implode(', ', $p['zachet_sem']));
            $sheet->SetCellValue('F'.$rowCount, @$p['project_sem']);
            $sheet->SetCellValue('G'.$rowCount, $p['control'] ? $p['control'] : '');
            $sheet->SetCellValue('H'.$rowCount, $p['theory_main'] + $p['practice_main']);
            $sheet->SetCellValue('I'.$rowCount, $p['theory_main']);
            $sheet->SetCellValue('J'.$rowCount, $p['practice_main']);
            $sheet->SetCellValue('K'.$rowCount, $p['theory'] + $p['practice'] + @$p['project']);
            $sheet->SetCellValue('M'.$rowCount, $p['theory'] ? $p['theory'] : '');
            $sheet->SetCellValue('N'.$rowCount, @$p['practice'] ? $p['practice'] : '');
            $sheet->SetCellValue('O'.$rowCount, @$p['project']);
            $sheet->SetCellValue('P'.$rowCount, @$p['weeks1']);
            $sheet->SetCellValue('Q'.$rowCount, @($p['sem1'] && $p['weeks1']) ? ceil($p['sem1'] / $p['weeks1']) :'');
            $sheet->SetCellValue('R'.$rowCount, @$p['sem1']);
            $sheet->SetCellValue('S'.$rowCount, @$p['weeks2']);
            $sheet->SetCellValue('T'.$rowCount, @($p['sem2'] && $p['weeks2']) ? ceil($p['sem2'] / $p['weeks2']) :'');
            $sheet->SetCellValue('U'.$rowCount, @$p['sem2']);
            $sheet->SetCellValue('V'.$rowCount, @$p['consul'] ? $p['consul'] : '');
            $sheet->SetCellValue('W'.$rowCount, @$p['exam'] ? $p['exam'] : '');
            $sheet->SetCellValue('X'.$rowCount, '=R'.$rowCount.'+U'.$rowCount.'+V'.$rowCount.'+W'.$rowCount);
            $sheet->SetCellValue('AA'.$rowCount, '=X'.$rowCount.'-Z'.$rowCount);
        }
        $rowCount++;
        $sheet->SetCellValue('C'.$rowCount, 'Итого');
        $sheet->SetCellValue('H'.$rowCount, "=SUM(H3:H".($rowCount-1).")");
        $sheet->SetCellValue('I'.$rowCount, "=SUM(I3:I".($rowCount-1).")");
        $sheet->SetCellValue('J'.$rowCount, "=SUM(J3:J".($rowCount-1).")");
        $sheet->SetCellValue('K'.$rowCount, "=SUM(K3:K".($rowCount-1).")");
        $sheet->SetCellValue('M'.$rowCount, "=SUM(M3:M".($rowCount-1).")");
        $sheet->SetCellValue('P'.$rowCount, "=SUM(P3:P".($rowCount-1).")");
        $sheet->SetCellValue('Q'.$rowCount, "=SUM(Q3:Q".($rowCount-1).")");
        $sheet->SetCellValue('R'.$rowCount, "=SUM(R3:R".($rowCount-1).")");
        $sheet->SetCellValue('S'.$rowCount, "=SUM(S3:S".($rowCount-1).")");
        $sheet->SetCellValue('T'.$rowCount, "=SUM(T3:T".($rowCount-1).")");
        $sheet->SetCellValue('U'.$rowCount, "=SUM(U3:U".($rowCount-1).")");
        $sheet->SetCellValue('V'.$rowCount, "=SUM(V3:V".($rowCount-1).")");
        $sheet->SetCellValue('W'.$rowCount, "=SUM(W3:W".($rowCount-1).")");
        $sheet->SetCellValue('X'.$rowCount, "=SUM(X3:X".($rowCount-1).")");
        $sheet->SetCellValue('X'.$rowCount, "=SUM(X3:X".($rowCount-1).")");
        $sheet->SetCellValue('Y'.$rowCount, "=SUM(Y3:Y".($rowCount-1).")");
        $sheet->SetCellValue('Z'.$rowCount, "=SUM(Z3:Z".($rowCount-1).")");
        $sheet->SetCellValue('AA'.$rowCount, "=SUM(AA3:AA".($rowCount-1).")");
        $styleArray = array(
         'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
        'font'  => array(
            'bold'  => false,
            'size'  => 12,
            'name'  => 'Times New Roman'
        ));
        $sheet->getStyle('A1:AA'.$rowCount)->applyFromArray($styleArray);
        $sheet->getStyle('A1:AA2')->getFont()->setBold(true);
        $sheet->getStyle('A'.$rowCount.':AA'.$rowCount)->getFont()->setBold(true);
        $sheet->getStyle('A1:AA2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:AA2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getStyle('C1:C'.$sheet->getHighestRow())
        ->getAlignment()->setWrapText(true);
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('file.xlsx');
        return response()->file('file.xlsx');
    }
}
