<?php

namespace App\Http\Controllers;
use App\Department;
use App\Lang;
use App\Group;
use App\Schedule;
use App\Plan;
use App\Cab;
use App\Teacher;
use App\ExcelHelper;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScheduleController extends Controller
{
	public function index()
	{
		return view('schedule.index', [
			'departments' => Department::all(),
			'langs' => Lang::all(),
		]);
	}

	public function group()
	{
		return view('schedule.group', [
			'groups' => Group::orderBy('name', 'asc')->get(),
		]);
	}

	public function teacher()
	{
		return view('schedule.teacher', [
			'teachers' => Teacher::orderBy('surname', 'asc')
			->orderBy('name', 'asc')
			->orderBy('patronymic', 'asc')->get(),
		]);
	}

	public function cab()
	{
		return view('schedule.cab', [
			'cabs' => Cab::with('corpus')->orderBy('num', 'asc')->get(),
		]);
	}

	public function edit()
	{
		$group = \Request::get('group');
		$year = \Request::get('year');
		$semestr = \Request::get('semestr');
		$schedule = Schedule::with('cab')
		->where('group_id', $group)
		->where('year', $year)
		->where('semestr', $semestr)->get()->map(function($val) {
			$val['teacher'] = $val->plan->teacher;
			$val['subject'] = $val->plan->subject;
			$val['subgroup'] = $val->plan->subgroup;
			return $val;
		});
		$list = [];
		$grp = Group::find($group);
		if($semestr) {
			$list = Plan::where('group_id', $group)
			->with('subject')
			->with('teacher')
			->where('year', $year)
			->where('semestr', ($year - $grp->year_create) * 2 + $semestr)	
			->where('total', '>', 0)
			->whereNotIn('cikl_id', [6,7,9])
			->orderBy('subject_id', 'asc')
			->orderBy('subgroup', 'asc')
			->get()
			->map(function($val) {
				$val['given'] = 0;
				if($val->subgroup == 2) {
					$val['hours'] = $val->main->weeks ? round($val->main->total / $val->main->weeks) / 2 : 0;
				}
				else {
					$val['hours'] = $val->weeks ? round($val->total / $val->weeks) / 2 : 0;
				}
				return $val;
			});
		}
		return view('schedule.edit', [
			'schedule' => $schedule,
			'list' => $list,
			'groups' => Group::orderBy('name', 'asc')->get(),
			'cabs' => Cab::all()
		]);
	}

	public function allowcab($day, $num, $week)
	{
		$year = \Request::get('year');
		$semestr = \Request::get('semestr');
		$group = \Request::get('group');
		$schedule = Schedule::select('cab_id')
		->where('year', $year)
		->where('semestr', $semestr)
		->where('day', $day)
		->where('num', $num)
		->where('week', $week)
		->where('group_id', '<>', $group)
		->distinct()->get()->pluck('cab_id')->toArray();
		$list = Cab::with('corpus')->whereNotIn('id', array_filter($schedule))->get();
		return $list;
	}

	public function receive($day, $num, $week, Request $request)
	{
		$year = \Request::get('year');
		$semestr = \Request::get('semestr');
		$warning = [];
		if(@$request->teacher['id']) {
			$teacherId = $request->teacher['id'];
			$sameTeacher = Schedule::where('year', $year)
			->where('semestr', $semestr)
			->where('day', $day)
			->where('num', $num)
			->whereIn('week', [$week, 0])
			->where('group_id', '<>', $request->group)
			->whereHas('plan', function($query) use($teacherId) {
				$query->where('teacher_id', $teacherId);
			})->first();
			if(!empty($sameTeacher)) {
				$warning[] =  "Наложение у ".$sameTeacher->plan->teacher->shortName.", ".$sameTeacher->plan->subject->name." ".$sameTeacher->group->name;
			}
		}
		if(@$request->cab['id']) {
			$sameCab = Schedule::where('year', $year)
			->where('semestr', $semestr)
			->where('day', $day)
			->where('num', $num)
			->whereIn('week', [$week, 0])
			->where('group_id', '<>', $request->group)
			->where('cab_id', $request->cab['id'])->first();
			if(!empty($sameCab)) {
				$warning[] =  "Наложение в ".$sameCab->cab->name.", ".$sameCab->plan->subject->name." ".$sameCab->group->name;
			}
		}
		return implode('<br>', $warning);
	}

	public function store(Request $request)
	{
		$group = \Request::get('group');
		$year = \Request::get('year');
		$semestr = \Request::get('semestr');
		Schedule::where('group_id', $group)
		->where('year', $year)
		->where('semestr', $semestr)
		->whereNotIn('id', array_column($request->data, 'schedule_id'))->delete();
		foreach($request->data as $item) {
			$sch = Schedule::updateOrCreate([
				'group_id' => $group,
				'year' => $year,
				'semestr' => $semestr,
				'day' => $item['day'],
				'num' => $item['num'],
				'week' => $item['week'],
				'subgroup' => $item['subgroup'],
			], [
				'plan_id' => $item['plan_id'],
				'cab_id' => $item['cab_id'],
			]);
			$sch->save();
		}
	}

	public function reset()
	{
		$group = \Request::get('group');
		$year = \Request::get('year');
		$semestr = \Request::get('semestr');
		$schedule = Schedule::where('group_id', $group)
		->where('year', $year)
		->where('semestr', $semestr)->delete();
		return redirect()->back();
	}

	public function export()
	{
		$year = \Request::get('year');
		$semestr = \Request::get('semestr');
		$department = \Request::get('department');
		$lang = \Request::get('lang');
		$kurs = \Request::get('kurs');
		$main = Schedule::where('year', $year)
		->where('semestr', $semestr);
		if($department !== null) {
			$main->whereHas('group', function($query) use($department) {
				$query->whereHas('specialization', function($q) use($department) {
					$q->where('department_id', $department);
				});
			});
		}
		if($lang !== null) $main->whereHas('group', function($query) use($lang) {
			$query->where('lang_id', $lang);
		});
		if($kurs !== null) $main->whereHas('group', function($query) use($kurs) {
			$query->whereRaw('year - year_create + 1 = '.$kurs);
		});
		$data = $main->orderBy('day', 'asc')
		->orderBy('num', 'asc')
		->get();
		$table = [];
		$groups = [];
		foreach($data as $i) {
			$table[$i->group_id][$i->day][$i->num][$i->week][] = [
				'subject' => $i->plan->subject->name,
				'teacher' => $i->teacher->shortName,
				'cab' => $i->cab->num,
			];
			$groups[$i->group_id] = $i->group->name;
		}
		$days = ['Дүйсенбі', 'Сейсенбі', 'Сәрсенбі', 'Бейсенбі', 'Жұма'];
		$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = 8;
        $sheet->setCellValue('B7', "Сабақ\nУрок ");
        for($d = 1; $d <= 5; $d++) {
        	$sheet->setCellValue('A'.$row, $days[$d - 1]);
        	$sheet->mergeCells('A'.$row.':A'.($row+14));
        	for($n = 1; $n <= 7; $n++) {
        		$sheet->setCellValue('B'.$row, $n);
        		$sheet->mergeCells('B'.$row.':C'.($row+1));
        		$row += 2;
        	}
        	$row++;
        }
        $col = 3;
        foreach($groups as $group) {
        	$sheet->setCellValue(ExcelHelper::col($col).'7', $group);
        	$sheet->setCellValue(ExcelHelper::col($col+1).'7', 'Ауд');
        	$sheet->getStyle(ExcelHelper::col($col).'7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        	$sheet->getStyle(ExcelHelper::col($col+1).'7')->getAlignment()->setTextRotation(90);
        	$col += 2;
        }
        $row = 8;
        for($d = 1; $d <= 5; $d++) {
        	for($n = 1; $n <= 7; $n++) {
        		$col = 3;
        		foreach($groups as $id => $group) {
        			$c1 = ExcelHelper::col($col);
        			$c2 = ExcelHelper::col($col + 1);        			
        			$sheet->getColumnDimension($c1)->setWidth(40);
			        $sheet->getStyle($c1.'8:'.$c1.$sheet->getHighestRow())
			        ->getAlignment()->setWrapText(true);
        			if(isset($table[$id][$d][$n])) {
        				$num = $table[$id][$d][$n];
        				if(isset($num[0])) {
        					$sheet->setCellValue($c1.$row, implode("\n", array_unique(array_column($num[0],'subject'))));
        					$sheet->setCellValue($c2.$row, implode("\n", array_unique(array_column($num[0],'cab'))));
        					$sheet->setCellValue($c1.($row+1), implode("/", array_unique(array_column($num[0],'teacher'))));
        					$sheet->mergeCells($c2.$row.':'.$c2.($row+1));
        				} else {
        					if(isset($num[1])) {
	        					$sheet->setCellValue($c1.$row, implode("\n", array_unique(array_column($num[1],'subject')))
	        						." ".implode("/", array_unique(array_column($num[1],'teacher'))));
	        					$sheet->setCellValue($c2.$row, implode("\n", array_unique(array_column($num[1],'cab'))));
	        				}
        					if(isset($num[2])) {
	        					$sheet->setCellValue($c1.($row+1), implode("\n", array_unique(array_column($num[2],'subject')))
	        						." ".implode("/", array_unique(array_column($num[2],'teacher'))));
	        					$sheet->setCellValue($c2.($row+1), implode("\n", array_unique(array_column($num[2],'cab'))));
	        				}
        				}
        			}
        			$col += 2;
        		}
        		$row += 2;
        	}
        	$sheet->mergeCells('B'.$row.':'.ExcelHelper::col($col-1).$row);
        	$row++;
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
        ));
        $sheet->getStyle('A7:'.ExcelHelper::col($col-1).($row-1))->applyFromArray($styleArray);
        $sheet->getStyle('A8:A68')->getAlignment()->setTextRotation(90);
        $sheet->getStyle('B7:C7')->getAlignment()->setTextRotation(90);
        $sheet->getStyle('A8:A68')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A8:A68')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $writer = new Xlsx($spreadsheet);
        $writer->save('file.xlsx');
        return response()->file('file.xlsx');
	}
}
