<?php

namespace App\Http\Controllers\Api;
use App\Schedule;
use App\Lesson;
use App\Group;
use App\Holiday;
use App\DateConvert;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChangeController extends Controller
{
	public function index()
	{
		$date = \Request::get('date') ?? date('Y-m-d');
		if (Holiday::where('date', $date)->exists()) return [];
		$department = \Request::get('department');
		$lang = \Request::get('lang');

		$dataChange = Lesson::where('date', $date)->orderBy('num', 'asc')->get();
		$changes = [];
		foreach ($dataChange as $key => $item) {
			$changes[$item->group_id][$item->num][] = $item;
		}

		$sqlGroups = Group::query();
		if($department !== null) {
			$sqlGroups->whereHas('specialization', function($query) use($department) {
				$query->where('department_id', $department);
			});
		}
		if($lang !== null) $sqlGroups->where('lang_id', $lang);
		$groups = $sqlGroups
		->orderBy('specialization_id', 'asc')
		->orderBy('kurs', 'asc')
		->orderBy('lang_id', 'asc')
		->orderBy('name', 'asc')
		->get();
		$schedule = [];
		foreach($groups as $g) {
			$obj = [];
			$current = DateConvert::convert($date, $g->id);
			$main = [];
			if($current['teor']) {
				$dataMain = Schedule::where('year', $current['year'])
				->where('semestr', $current['semestr'])
				->where('day', $current['day'])
				->whereIn('week', [$current['week'], 0])
				->where('group_id', $g->id)
				->orderBy('num', 'asc')->get();
				foreach ($dataMain as $key => $item) {
					$main[$item->num][] = $item;
				}
			}
			for($n = 1; $n <= 7; $n++) {
				$items = [];
				if(isset($changes[$g->id])) {
					if(isset($changes[$g->id][$n])) {
						$items = $changes[$g->id][$n];
					} else continue;					
				} elseif(isset($main[$n])) {
					$items = $main[$n];
				}
				foreach($items as $item) {
					$les['teacher'] = $item->teacher->shortName;
					$les['subject'] = $item->plan->subject->name;
					$les['cab'] = $item->cab->num;
					$obj['name'] = $item->group->name;			
					$obj['lessons'][$item->num][] = $les;
				}
			}
			if($obj) $schedule[] = $obj;
		}
		return $schedule;
	}

	public function group()
	{
		$date = \Request::get('date') ?? date('Y-m-d');
		if (Holiday::where('date', $date)->exists()) return [];
		$group = \Request::get('group');

		$dataChange = Lesson::where('date', $date)
		->where('group_id', $group)
		->orderBy('num', 'asc')->get();
		$schedule = [];
		$main = [];
		$changes = [];
		foreach ($dataChange as $key => $item) {
			$changes[$item->num][] = $item;
		}
		$current = DateConvert::convert($date, $group);
		if($current['teor']) {
			$dataMain = Schedule::where('year', $current['year'])
			->where('semestr', $current['semestr'])
			->where('day', $current['day'])
			->where('group_id', $group)
			->orderBy('num', 'asc')->get();
			foreach ($dataMain as $key => $item) {
				$main[$item->num][] = $item;
			}
		}
		for($n = 1; $n <= 7; $n++) {
			$items = [];
			if(!empty($changes)) {
				if(isset($changes[$n])) {
					$items = $changes[$n];
				} else continue;					
			} elseif(isset($main[$n])) {
				$items = $main[$n];
			}
			foreach($items as $item) {
				$les['teacher'] = $item->teacher->shortName;
				$les['subject'] = $item->plan->subject->name;
				$les['cab'] = $item->cab->num;		
				$schedule[$item->num][] = $les;
			}
		}
		return $schedule;
	}

	public function teacher()
	{
		$date = \Request::get('date') ?? date('Y-m-d');
		if (Holiday::where('date', $date)->exists()) return [];
		$department = \Request::get('department');
		$teacher = \Request::get('teacher');

		$dataChange = Lesson::where('date', $date)
		->where('teacher_id', $teacher)
		->orderBy('num', 'asc')->get();
		$changes = [];
		foreach ($dataChange as $key => $item) {
			$changes[$item->group_id][$item->num][] = $item;
		}

		$groups = Group::all();
		$schedule = [];
		foreach($groups as $g) {
			$current = DateConvert::convert($date, $g->id);
			$main = [];
			if($current['teor']) {
				$dataMain = Schedule::where('year', $current['year'])
				->where('semestr', $current['semestr'])
				->where('day', $current['day'])
				->whereIn('week', [$current['week'], 0])
				->where('group_id', $g->id)
				->whereHas('plan', function($query) use($teacher) {
					$query->where('teacher_id', $teacher);
				})
				->orderBy('num', 'asc')->get();
				foreach ($dataMain as $key => $item) {
					$main[$item->num][] = $item;
				}
			}
			for($n = 1; $n <= 7; $n++) {
				$items = [];
				if(isset($changes[$g->id])) {
					if(isset($changes[$g->id][$n])) {
						$items = $changes[$g->id][$n];
					} else continue;					
				} elseif(isset($main[$n])) {
					$items = $main[$n];
				}
				foreach($items as $item) {
					$les['teacher'] = $item->teacher->shortName;
					$les['subject'] = $item->plan->subject->name.', '.$item->group->name;
					$les['cab'] = $item->cab->num;		
					$schedule[$item->num][] = $les;
				}
			}
		}
		return $schedule;
	}
}
