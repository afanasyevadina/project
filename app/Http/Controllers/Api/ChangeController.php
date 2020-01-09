<?php

namespace App\Http\Controllers\Api;
use App\Schedule;
use App\Change;
use App\DateConvert;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChangeController extends Controller
{
	public function index()
	{
		$date = \Request::get('date');
		$current = DateConvert::convert($date);
		$department = \Request::get('department');
		$lang = \Request::get('lang');

		$dataChange = Change::where('day', $date)->orderBy('num', 'asc')->get();
		$changes = [];
		foreach ($dataChange as $key => $item) {
			$changes[$item->group_id]['name'] = $item->group->name;
			$changes[$item->group_id]['lessons'][$item->num] = $item;
		}

		$main = Schedule::join('groups', 'schedules.group_id', '=', 'groups.id')
		->where('year', $current['year'])
		->where('semestr', $current['semestr'])
		->where('day', date('N', strtotime($date)));
		if($department !== null) $main->where('department_id', $department);
		if($lang !== null) $main->where('lang_id', $lang);
		$data = $main
		->orderBy('department_id', 'asc')
		->orderBy('lang_id', 'asc')
		->orderBy('name', 'asc')
		->orderBy('num', 'asc')
		->get();
		$schedule = [];
		foreach ($data as $key => $item) {
			if(isset($changes[$item->group_id])) {
				if(isset($changes[$item->group_id]['lessons'][$item->num])) {
					if(!$changes[$item->group_id]['lessons'][$item->num]->is_main)
						$item = $changes[$item->group_id]['lessons'][$item->num];
				} else continue;					
			}
			$schedule[$item->group_id]['name'] = $item->group->name;			
			$schedule[$item->group_id]['lessons'][$item->num] = $item;
		}
		return $schedule;
	}
}
