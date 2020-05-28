<?php

namespace App\Http\Controllers;
use App\Subject;
use App\Teacher;
use App\Plan;
use App\Lesson;
use App\Group;
use App\ExcelHelper;
use App\DateConvert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocController extends Controller
{
    public function form3()
    {
        $year = \Request::get('year');
        $teacherId = \Request::get('teacher');
        if($year) {
            $spreadsheet = new Spreadsheet();
            $index = 0;
            $months=[
                10 => '09',
                11 => '10',
                12 => '11',
                13 => '12',
                14 => '01',
                15 => '02',
                16 => '03',
                17 => '04',
                18 => '05',
                19 => '06',
            ];
            $teacher = Teacher::findOrFail($teacherId);
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle($teacher->shortName);
            $sheet->setCellValue('A2', 'Министерство образования и науки РК');
            $sheet->setCellValue('A3', 'Ведомость учета учебного времени преподавателя КГП на ПХВ "КИТ"');
            $sheet->setCellValue('A5', 'Годовой учет часов, данных преподавателем в '.$year.'-'.($year+1).' учебном году');
            $sheet->setCellValue('A6', 'ФИО преподавателя: '.$teacher->shortName);
            $sheet->setCellValue('A8', 'Группы');
            $sheet->setCellValue('A9', "Предмет/Месяцы");
            $sheet->setCellValue('A10', 'Сентябрь');
            $sheet->setCellValue('A11', 'Октябрь');
            $sheet->setCellValue('A12', 'Ноябрь');
            $sheet->setCellValue('A13', 'Декабрь');
            $sheet->setCellValue('A14', 'Январь');
            $sheet->setCellValue('A15', 'Февраль');
            $sheet->setCellValue('A16', 'Март');
            $sheet->setCellValue('A17', 'Апрель');
            $sheet->setCellValue('A18', 'Май');
            $sheet->setCellValue('A19', 'Июнь');
            $sheet->setCellValue('A20', 'Консультации');
            $sheet->setCellValue('A21', 'Экзамены');
            $sheet->setCellValue('A22', 'Курс.проект');
            $sheet->setCellValue('A23', 'Дипл.проект');
            $sheet->setCellValue('A24', 'Практика');
            $sheet->setCellValue('A25', 'Участие в ГКК');
            $sheet->setCellValue('A26', 'Всего дано часов');
            $sheet->setCellValue('A27', 'Всего часов по плану');
            $sheet->setCellValue('A28', 'Не выполнено часов');
            $sheet->setCellValue('A29', 'Дано часов сверх плана');
            $sheet->setCellValue('A30', 'Всего часов за год');
            $sheet->setCellValue('AJ9', 'ВСЕГО');
            $sheet->setCellValue('AK2', 'Министерство образования и науки РК');
            $sheet->setCellValue('AK3', 'Ведомость учета учебного времени преподавателя КГП на ПХВ "КИТ"');
            $sheet->setCellValue('AK5', 'Годовой учет часов, данных преподавателем в '.$year.'-'.($year+1).' учебном году');
            $sheet->setCellValue('AK6', 'ФИО преподавателя: '.$teacher->shortName);
            $sheet->setCellValue('AK8', 'Группы');
            $sheet->setCellValue('AK9', "Предмет/Месяцы");
            $sheet->setCellValue('AK10', 'Сентябрь');
            $sheet->setCellValue('AK11', 'Октябрь');
            $sheet->setCellValue('AK12', 'Ноябрь');
            $sheet->setCellValue('AK13', 'Декабрь');
            $sheet->setCellValue('AK14', 'Январь');
            $sheet->setCellValue('AK15', 'Февраль');
            $sheet->setCellValue('AK16', 'Март');
            $sheet->setCellValue('AK17', 'Апрель');
            $sheet->setCellValue('AK18', 'Май');
            $sheet->setCellValue('AK19', 'Июнь');
            $sheet->setCellValue('AK20', 'Консультации');
            $sheet->setCellValue('AK21', 'Экзамены');
            $sheet->setCellValue('AK22', 'Курс.проект');
            $sheet->setCellValue('AK23', 'Дипл.проект');
            $sheet->setCellValue('AK24', 'Практика');
            $sheet->setCellValue('AK25', 'Участие в ГКК');
            $sheet->setCellValue('AK26', 'Всего дано часов');
            $sheet->setCellValue('AK27', 'Всего часов по плану');
            $sheet->setCellValue('AK28', 'Не выполнено часов');
            $sheet->setCellValue('AK29', 'Дано часов сверх плана');
            $sheet->setCellValue('AK30', 'Всего часов за год');
            $sheet->setCellValue('BA9', 'ВСЕГО');
            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('AK')->setAutoSize(true);
            for($i=10;$i<=30;$i++) {
                $sheet->setCellValue('AJ'.$i, '=SUM(B'.$i.':AI'.$i.')');
                $sheet->setCellValue('BA'.$i, '=SUM(AL'.$i.':AZ'.$i.')');
            }
            $items = Plan::where('teacher_id', $teacher->id)
            ->where('year', $year)
            ->orderBy('group_id', 'asc')
            ->orderBy('subject_id', 'asc')->get();

            $i=0; //num of column

            foreach($items as $key => $item) {
                $i++;
                if(
                    @$items[$key - 1]->group_id == $item->group_id &&
                    @$items[$key - 1]->subject_id == $item->subject_id &&
                    @$items[$key - 1]->semestr != $item->semestr
                ) {
                    $i--;
                }
                $col = ExcelHelper::col($i);
                $sheet->setCellValue($col.'8', $item->group->codes[$item->kurs]);
                $sheet->setCellValue($col.'9', $item->subject->name);

                    //walking through the list of months
                for($j=10;$j<=19;$j++) {
                        //slice of lessons which was in current month
                    $lessons = $item->lessons()
                    ->where('teacher_id', $teacher->id)
                    ->whereMonth('date', $months[$j])->sum('total');
                    $val = $sheet->getCell($col.$j)->getValue();
                    $sheet->setCellValue($col.$j, $val + $lessons);
                }
                $val = $sheet->getCell($col.'20')->getValue();
                $sheet->setCellValue($col.'20', $val + $item->consul);
                $val = $sheet->getCell($col.'21')->getValue();
                $sheet->setCellValue($col.'21', $val + $item->exam);
                $sheet->setCellValue($col.'26', '=SUM('.$col.'10:'.$col.'25)');
                $val = $sheet->getCell($col.'27')->getValue();
                $sheet->setCellValue($col.'27', $val + $item->total+$item->exam+$item->consul);
                $sheet->setCellValue($col.'28', '='.$col.'27-'.$col.'26');
                $sheet->setCellValue($col.'30', '='.$col.'26+'.$col.'29');
            }

            $items = Plan::where('teacher_id', '<>', $teacher->id)
            ->where('year', $year)
            ->whereHas('lessons', function($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })
            ->orderBy('group_id', 'asc')
            ->orderBy('subject_id', 'asc')->get();

            $i=36; //num of column

            foreach($items as $key => $item) {
                $i++;
                if(
                    @$items[$key - 1]->group_id == $item->group_id &&
                    @$items[$key - 1]->subject_id == $item->subject_id &&
                    @$items[$key - 1]->semestr != $item->semestr
                ) {
                    $i--;
                }
                $col = ExcelHelper::col($i);
                $sheet->setCellValue($col.'8', $item->group->codes[$item->kurs]);
                $sheet->setCellValue($col.'9', $item->subject->name);

                    //walking through the list of months
                for($j=10;$j<=19;$j++) {
                        //slice of lessons which was in current month
                    $lessons = $item->lessons()
                    ->where('teacher_id', $teacher->id)
                    ->whereMonth('date', $months[$j])->sum('total');
                    $val = $sheet->getCell($col.$j)->getValue();
                    $sheet->setCellValue($col.$j, $val + $lessons);
                }
                $sheet->setCellValue($col.'26', '=SUM('.$col.'10:'.$col.'25)');
                $sheet->setCellValue($col.'30', '='.$col.'26');
            }            
            $styleArray = array(
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
                'font'  => array(
                    'bold'  => false,
                    'size'  => 12,
                    'name'  => 'Times New Roman'
                )
            );
            $fillArray = array(
                'fill' => array(
                    'type' => Fill::FILL_SOLID,
                    'color' => array('rgb' => '868686')
                )
            );
            $sheet->getStyle('A8:BA30')->applyFromArray($styleArray);
            $sheet->getStyle('B8:AJ9')->getAlignment()->setTextRotation(90);
            $sheet->getStyle('AL8:BA9')->getAlignment()->setTextRotation(90);
            $sheet->mergeCells('A2:AJ2');
            $sheet->mergeCells('A3:AJ3');
            $sheet->mergeCells('A5:AJ5');
            $sheet->mergeCells('A6:AJ6');
            $sheet->mergeCells('AK2:BA2');
            $sheet->mergeCells('AK3:BA3');
            $sheet->mergeCells('AK5:BA5');
            $sheet->mergeCells('AK6:BA6');
            $sheet->getStyle('A2:AJ3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('AK2:BA3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('AK')->setAutoSize(true);
            $sheet->getRowDimension('8')->setRowHeight(50);
            $sheet->getRowDimension('9')->setRowHeight(200);
            $sheet->getStyle('A8:BA9')->getAlignment()->setWrapText(true);
            $sheet->getStyle('A2:BA7')->getFont()->setBold(true)->setSize(12)->setName("Times new Roman");
            $sheet->getStyle('B26:AJ27')->getFont()->setBold(true);
            $sheet->getStyle('B30:AJ30')->getFont()->setBold(true);
            $sheet->getStyle('AL26:BA27')->getFont()->setBold(true);
            $sheet->getStyle('AL30:BA30')->getFont()->setBold(true);
            $sheet->getStyle('A20:BA21')->applyFromArray($fillArray);
            $sheet->getStyle('A26:BA26')->applyFromArray($fillArray);
            $sheet->getStyle('A30:BA30')->applyFromArray($fillArray);
            $sheet->getStyle('A27:BA30')->applyFromArray($fillArray);
            $writer = new Xlsx($spreadsheet);
            header('Content-Disposition: attachment; filename="'.$teacher->shortName.' '.$year.'-'.($year+1).'.xlsx"');
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            $writer->save('php://output');
            return;
        }
        return view('doc.form3', [
            'teachers' => Teacher::all()->sortBy('fullName')
        ]);
    }

    public function form2()
    {
        $year = \Request::get('year');
        $semestr = \Request::get('semestr');
        $month = \Request::get('month');
        $groupId = \Request::get('group');
        if($groupId) {
            $group = Group::findOrFail($groupId);
            $calendYear = (int)$month < 7 ? $year + 1 : $year;
            $semestr = ($year - $group->year_create) * 2 + $semestr;
            $monthDays = DateConvert::monthDays($month, $calendYear);
            $plans = Plan::where('group_id', $groupId)
            ->where('year', $year)
            ->where('semestr', $semestr)->get();
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle(DateConvert::month($month));
            $sheet->setCellValue('A1', 'Министерство образования и науки Республики Казахстан');
            $sheet->setCellValue('A2', 'ведомость учета учебного времени работы преподавателей на '.DateConvert::month($month).' месяц '.$calendYear.' год');
            $sheet->setCellValue('A3', 'Специальность(профессия) '.@$group->codes[ceil($semestr/2)]);
            $sheet->setCellValue('A6', 'Преподаватель');
            $sheet->setCellValue('B6', 'Предмет');
            $sheet->setCellValue('C6', 'всего часов');
            $i = 2;
            for($day = 1; $day <= $monthDays; $day++) {
                $i++;
                $sheet->setCellValue(ExcelHelper::col($i).'6', $day);
                $sheet->getColumnDimension(ExcelHelper::col($i))->setWidth(3);
            }
            $i++;
            $sheet->setCellValue(ExcelHelper::col($i).'6', 'Выдан');
            $i++;
            $sheet->setCellValue(ExcelHelper::col($i).'6', 'всего осталось');
            $row = 6;
            $second = $facult = $replaced = [];
            foreach ($plans as $key => $plan) {
                if(in_array($plan->cikl_id, [7, 9])) continue;
                if($plan->subgroup == 2) {
                    $second[] = $plan; continue;
                }
                if($plan->cikl_id == 8) {
                    $facult[] = $plan; continue;
                }
                $row++;
                $sheet->setCellValue('A'.$row, $plan->teacher->shortName);
                $sheet->setCellValue('B'.$row, $plan->subject->name);
                $gone = $plan->lessons()->where('date', '<', $calendYear.'-'.$month.'-01')->sum('total');
                $sheet->setCellValue('C'.$row, $plan->total - $gone);
                $i = 2;
                for($day = 1; $day <= $monthDays; $day++) {
                    $i++;
                    $lessons = $plan->lessons()->whereMonth('date', $month)->whereDay('date', $day)->sum('total');
                    if($lessons) $sheet->setCellValue(ExcelHelper::col($i).$row, $lessons);
                }
                $i++;
                $sheet->setCellValue(ExcelHelper::col($i).$row, '=SUM(D'.$row.':'.ExcelHelper::col($i-1).$row.')');
                $i++;
                $sheet->setCellValue(ExcelHelper::col($i).$row, '=C'.$row.'-'.ExcelHelper::col($i-1).$row);
                $rep = $plan->lessons()->whereMonth('date', $month)
                ->where('teacher_id', '<>', $plan->teacher_id)->get();
                foreach($rep as $t) {
                    if($t) {
                        $replaced[$plan->id.$t->teacher_id] = $plan;
                        $replaced[$plan->id.$t->teacher_id]->teacher = $t->teacher;
                    }
                }
            }
            $row++;
            $sheet->setCellValue('A'.$row, 'Итого');
            $sheet->setCellValue('C'.$row, '=SUM(C7:C'.($row-1).')');
            $i = 2;
            for($day = 1; $day <= $monthDays; $day++) {
                $i++;
                $col = ExcelHelper::col($i);
                $sheet->setCellValue(ExcelHelper::col($i).$row, '=SUM('.$col.'7:'.$col.($row-1).')');
            }
            $i++;
            $sheet->setCellValue(ExcelHelper::col($i).$row, '=SUM(D'.$row.':'.ExcelHelper::col($i-1).$row.')');
            $i++;
            $sheet->setCellValue(ExcelHelper::col($i).$row, '=C'.$row.'-'.ExcelHelper::col($i-1).$row);
            foreach (array_merge($second, $facult) as $key => $plan) {
                $row++;
                $sheet->setCellValue('A'.$row, $plan->teacher->shortName);
                $sheet->setCellValue('B'.$row, $plan->subject->name);
                $gone = $plan->lessons()->where('date', '<', $calendYear.'-'.$month.'-01')->sum('total');
                $sheet->setCellValue('C'.$row, $plan->total - $gone);
                $i = 2;
                for($day = 1; $day <= $monthDays; $day++) {
                    $i++;
                    $lessons = $plan->lessons()->whereMonth('date', $month)->whereDay('date', $day)->sum('total');
                    if($lessons) $sheet->setCellValue(ExcelHelper::col($i).$row, $lessons);
                }
                $i++;
                $sheet->setCellValue(ExcelHelper::col($i).$row, '=SUM(D'.$row.':'.ExcelHelper::col($i-1).$row.')');
                $i++;
                $sheet->setCellValue(ExcelHelper::col($i).$row, '=C'.$row.'-'.ExcelHelper::col($i-1).$row);
            }
            foreach ($replaced as $key => $plan) {
                $row++;
                $sheet->setCellValue('A'.$row, $plan->teacher->shortName);
                $sheet->setCellValue('B'.$row, $plan->subject->name);
                $i = 2;
                for($day = 1; $day <= $monthDays; $day++) {
                    $i++;
                    $lessons = $plan->lessons()
                    ->where('teacher_id', $plan->teacher->id)
                    ->whereMonth('date', $month)
                    ->whereDay('date', $day)->sum('total');
                    if($lessons) $sheet->setCellValue(ExcelHelper::col($i).$row, $lessons);
                }
                $i++;
                $sheet->setCellValue(ExcelHelper::col($i).$row, '=SUM(D'.$row.':'.ExcelHelper::col($i-1).$row.')');
                $i++;
            }
            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setWidth(40);
            $sheet->getStyle('A6:'.ExcelHelper::col($i).$row)->getAlignment()->setWrapText(true);
            $styleArray = array(
             'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'font'  => array(
                'bold'  => false,
                'size'  => 10,
                'name'  => 'Times New Roman'
            ));
            $sheet->mergeCells('A1:'.ExcelHelper::col($i).'1');
            $sheet->mergeCells('A2:'.ExcelHelper::col($i).'2');
            $sheet->mergeCells('A3:'.ExcelHelper::col($i).'3');
            $sheet->getStyle('A6:'.ExcelHelper::col($i).$row)->applyFromArray($styleArray);
            $sheet->getStyle('A1:'.ExcelHelper::col($i).'3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:'.ExcelHelper::col($i).'3')->getFont()->setBold(true)->setSize(12)->setName("Times new Roman");
            $writer = new Xlsx($spreadsheet);
            header('Content-Disposition: attachment; filename="'.@$group->codes[ceil($semestr/2)].' '.DateConvert::month($month).'.xlsx"');
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            $writer->save('php://output');
            return;
        }
        return view('doc.form2', [
            'groups' => Group::orderBy('name')->get(),
        ]);
    }
}
