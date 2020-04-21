<?php

namespace App\Http\Controllers\Api;
use App\Schedule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
	public function index()
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
		$schedule = [];
		foreach ($data as $key => $item) {
			$les['teacher'] = $item->plan->teacher->shortName;
			$les['subject'] = $item->plan->subject->name;
			$les['cab'] = $item->cab->num;
			$schedule[$item->day][$item->group_id]['name'] = $item->group->name;
			$schedule[$item->day][$item->group_id]['lessons'][$item->num][$item->week][] = $les;
		}
		return $schedule;
	}
	public function group()
	{
		$year = \Request::get('year');
		$semestr = \Request::get('semestr');
		$group = \Request::get('group');
		$data = Schedule::where('year', $year)
		->where('semestr', $semestr)
		->where('group_id', $group)
		->orderBy('day', 'asc')
		->orderBy('num', 'asc')
		->get();
		$schedule = [];
		foreach ($data as $key => $item) {
			$les['teacher'] = $item->plan->teacher->shortName;
			$les['subject'] = $item->plan->subject->name;
			$les['cab'] = $item->cab->num;
			$schedule[$item->day][$item->num][$item->week][] = $les;
		}
		return $schedule;
	}

	public function teacher()
	{
		$year = \Request::get('year');
		$semestr = \Request::get('semestr');
		$teacher = \Request::get('teacher');
		$data = Schedule::where('year', $year)
		->where('semestr', $semestr)
		->whereHas('plan', function($query) use($teacher) {
			$query->where('teacher_id', $teacher);
		})
		->orderBy('day', 'asc')
		->orderBy('num', 'asc')
		->get();
		$schedule = [];
		foreach ($data as $key => $item) {
			$les['teacher'] = $item->plan->teacher->shortName;
			$les['subject'] = $item->plan->subject->name.', '.$item->group->name;
			$les['cab'] = $item->cab->num;
			$schedule[$item->day][$item->num][$item->week][] = $les;
		}
		return $schedule;
	}
	public function cab()
	{
		$year = \Request::get('year');
		$semestr = \Request::get('semestr');
		$cab = \Request::get('cab');
		$data = Schedule::where('year', $year)
		->where('semestr', $semestr)
		->where('cab_id', $cab)
		->orderBy('day', 'asc')
		->orderBy('num', 'asc')
		->get();
		$schedule = [];
		foreach ($data as $key => $item) {
			$les['teacher'] = $item->plan->teacher->shortName;
			$les['subject'] = $item->plan->subject->name.', '.$item->group->name;
			$les['cab'] = $item->cab->num;
			$schedule[$item->day][$item->num][$item->week][] = $les;
		}
		return $schedule;
	}
}
