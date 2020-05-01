<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Change;
use App\Lesson;
use App\Schedule;
use App\Plan;
use App\Department;
use App\Lang;
use App\Group;
use App\Cab;
use App\Teacher;
use App\DateConvert;
use Illuminate\Support\Facades\Storage;

class ChangeController extends Controller
{
	public function index()
	{
		return view('changes.index', [
			'departments' => Department::all(),
			'langs' => Lang::all(),
		]);
	}

	public function group()
	{
		return view('changes.group', [
			'groups' => Group::orderBy('name', 'asc')->get(),
		]);
	}

	public function teacher()
	{
		return view('changes.teacher', [
			'teachers' => Teacher::orderBy('surname', 'asc')
			->orderBy('name', 'asc')
			->orderBy('patronymic', 'asc')->get(),
		]);
	}

	public function edit()
	{
		$group = \Request::get('group');
		$date = \Request::get('date') ?? date('Y-m-d');
		$convert = DateConvert::convert($date, $group);
		$year = @$convert['year'];
		$semestr = @$convert['semestr'];		
		$day = @$convert['day'];		
		$week = @$convert['week'];	
		$list = $schedule = [];
		if($group && $date) {
			$grp = Group::find($group);
			$data = Plan::where('group_id', $group)
			->with('subject')
			->with('teacher')
			->where('year', $year)
			->where('semestr', ($year - $grp->year_create) * 2 + $semestr)	
			->whereNotIn('cikl_id', [6,7,9])
			->orderBy('subject_id', 'asc')
			->orderBy('subgroup', 'asc')
			->get();
			$list = $data->filter(function($val) use($date) {return $val->checkNext($date);})
			->map(function($val) use($date) {
				$lesson = $val->lessons()->whereNull('date')->orderBy('order', 'asc')->first();
				$lesson['teacher'] = $val->teacher;
				$lesson['subject'] = $val->subject;
				$lesson['given'] = $val->lessons()->whereNotNull('date')->count();
				$lesson['hours'] = $val->total / 2;
				return $lesson;
			})->toArray();	
			$schedule = Lesson::with('cab')->with('teacher')
			->where('group_id', $group)
			->where('date', $date)->get()->map(function($val) {
				$val['teacher'] = $val->teacher;
				$val['subject'] = $val->plan->subject;
				$val['lesson_id'] = $val->id;
				return $val;
			});
			if(!count($schedule)) {
				$schedule = Schedule::with('cab')
				->where('group_id', $group)
				->where('year', $year)
				->where('semestr', $semestr)
				->where('day', $day)
				->whereIn('week', [0, $week])
				->get();
				$schedule = $schedule->map(function($val) use($date) {
					if(!$val->plan->checkNext($date)) return false;
					$next = $val->plan->lessons()->whereNull('date')->orderBy('order', 'asc')->first();
					$val['teacher'] = $val->plan->teacher;
					$val['subject'] = $val->plan->subject;
					$val['subgroup'] = $next->subgroup;
					$val['lesson_id'] = @$next->id;
					return $val;
				})->toArray();
			}
		}
		return view('changes.edit', [
			'schedule' => $schedule,
			'list' => $list,
			'groups' => Group::orderBy('name')->get(),
			'cabs' => Cab::all(),
			'day' => $convert,
		]);
	}

	public function allowcab($num)
	{
		$date = \Request::get('date') ?? date('Y-m-d');
		$group = \Request::get('group');
		$convert = DateConvert::convert($date, $group);
		$changes = Lesson::select('cab_id')
		->where('date', $date)
		->where('num', $num)
		->where('group_id', '<>', $group)
		->distinct()->get()->pluck('cab_id')->toArray();
		$schedule = Schedule::select('cab_id', 'group_id')
		->where('year', @$convert['year'])
		->where('semestr', @$convert['semestr'])
		->where('week', @$convert['week'])
		->where('day', @$convert['day'])
		->where('num', $num)
		->where('group_id', '<>', $group)
		->distinct()->get()
		->filter(function($val) {
			return !Lesson::where('group_id', $val->group_id)->where('date', $date)->exists();
		})
		->pluck('cab_id')->toArray();
		$list = Cab::whereNotIn('id', array_filter(array_merge($schedule, $changes)))->get();
		return $list;
	}

	public function allowteacher($num)
	{
		$date = \Request::get('date') ?? date('Y-m-d');
		$group = \Request::get('group');
		$convert = DateConvert::convert($date, $group);
		$changes = Lesson::select('teacher_id')
		->where('date', $date)
		->where('num', $num)
		->where('group_id', '<>', $group)
		->distinct()->get()->pluck('teacher_id')->toArray();
		$schedule = Schedule::select('plan_id', 'group_id')
		->where('year', @$convert['year'])
		->where('semestr', @$convert['semestr'])
		->where('week', @$convert['week'])
		->where('day', @$convert['day'])
		->where('num', $num)
		->where('group_id', '<>', $group)
		->distinct()->get()
		->filter(function($val) {
			return !Lesson::where('group_id', $val->group_id)->where('date', $date)->exists();
		})->map(function($val) {
			return $val->plan->teacher_id;
		})->toArray();
		$list = Teacher::whereNotIn('id', array_filter(array_merge($schedule, $changes)))
		->get()->map(function($val) {
			$val['shortName'] = $val->shortName;
			$val['fullName'] = $val->fullName;
			return $val;
		});
		return $list;
	}

	public function receive($num, Request $request)
	{
		$date = \Request::get('date') ?? date('Y-m-d');
		$group = \Request::get('group');
		$convert = DateConvert::convert($date, $group);
		$warning = [];
		if(@$request->teacher['id']) {
			$teacherId = $request->teacher['id'];
			$sameTeacher = Lesson::where('teacher_id', $teacherId)
			->where('date', $date)
			->where('group_id', '<>', $group)->first();
			if(!empty($sameTeacher)) {
				$warning[] =  "Наложение у ".$sameTeacher->teacher->shortName.", ".$sameTeacher->plan->subject->name." ".$sameTeacher->group->name;
			} else {
				$sameTeacher = Schedule::where('year', @$convert['year'])
				->where('semestr', @$convert['semestr'])
				->whereIn('week', [@$convert['week'], 0])
				->where('day', @$convert['day'])
				->where('num', $num)
				->where('group_id', '<>', $group)
				->whereHas('plan', function($query) use($teacherId) {
					$query->where('teacher_id', $teacherId);
				})->first();
				if(!empty($sameTeacher) && !Lesson::where('group_id', $val->group_id)->where('date', $date)->exists()) {
					$warning[] =  "Наложение у ".$sameTeacher->plan->teacher->shortName.", ".$sameTeacher->plan->subject->name." ".$sameTeacher->group->name;
				}
			}
		}
		if(@$request->cab['id']) {
			$cabId = $request->cab['id'];
			$sameCab = Lesson::where('cab_id', $cabId)
			->where('date', $date)
			->where('group_id', '<>', $group)->first();
			if(!$sameCab) {
				$sameTeacher = Schedule::where('year', @$convert['year'])
				->where('semestr', @$convert['semestr'])
				->whereIn('week', [@$convert['week'], 0])
				->where('day', @$convert['day'])
				->where('num', $num)
				->where('cab_id', $cabId)
				->where('group_id', '<>', $group)->first();
			}
			if(!empty($sameCab) && !Lesson::where('group_id', $val->group_id)->where('date', $date)->exists()) {
				$warning[] =  "Наложение в ".$sameCab->cab->name.", ".$sameCab->plan->subject->name." ".$sameCab->group->name;
			}
		}
		return implode('<br>', $warning);
	}

	public function store(Request $request)
	{
		$group = \Request::get('group');
		$date = \Request::get('date');
		Lesson::where('group_id', $group)
		->where('date', $date)
		->update([
			'date' => null,
			'cab_id' => null,
			'num' => null,
			'teacher_id' => null,
		]);
		foreach($request->data as $item) {
			$lesson = Lesson::find($item['id']);
			if(empty($lesson)) continue;
			$lesson->num = $item['num'];
			$lesson->cab_id = $item['cab_id'];
			$lesson->teacher_id = $item['teacher_id'];
			$lesson->group_id = $group;
			$lesson->date = $date;
			$lesson->save();
		}
	}
}
