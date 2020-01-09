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
		$main = Schedule::join('groups', 'schedules.group_id', '=', 'groups.id')
		->where('year', $year)
		->where('semestr', $semestr);
		if($department !== null) $main->where('department_id', $department);
		if($lang !== null) $main->where('lang_id', $lang);
		$data = $main
		->orderBy('department_id', 'asc')
		->orderBy('lang_id', 'asc')
		->orderBy('name', 'asc')
		->orderBy('day', 'asc')
		->orderBy('num', 'asc')
		->get();
		$schedule = [];
		foreach ($data as $key => $item) {
			$schedule[$item->day][$item->group_id]['name'] = $item->group->name;
			$schedule[$item->day][$item->group_id]['lessons'][$item->num] = $item;
		}
		return $schedule;
	}
}
