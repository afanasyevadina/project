<?php

namespace App\Http\Controllers;
use App\Department;
use App\Lang;
use App\Group;
use App\Schedule;

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

	public function upload(Request $request)
	{
		$fileName = Storage::disk('public')->putFile('files', $request->file('file'));
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('public/storage/'.$fileName);
		foreach($spreadsheet->getWorksheetIterator() as $sheet) {
			$list = $sheet->toArray();

			$list = array_slice($list, 6);

			$groups = [];
			$source = collect(Group::all()->pluck('name'))->combine(Group::all()->pluck('id'));
			$header = array_shift($list);
			foreach(array_slice($header, 3) as $col => $cell) {
				if($col % 2 == 0 && $cell) {
					if(isset($source[$cell]))
						$groups[$col]['group'] = $source[$cell];
					else {
						echo "Undefined ".$cell; return;
					}
				}
			}
			foreach($list as $key => $row) {
				if(!$row[1] && !@$list[$key - 1][1]) unset($list[$key]);
			}

			$day = '';
			$daysCount = 0;
			$num = 0;
			foreach(array_values($list) as $key => $row) {
				if($row[0]) {
					$day = $row[0];
					$daysCount++;
					if($daysCount > 5) break;
				}
				if($row[1]) $num = $row[1];
				if($key % 2 == 0) {
					foreach(array_slice($row, 3, count($groups) * 2) as $col => $cell) {
						if($col % 2 == 0) 
							$groups[$col]['lessons'][$day][$num]['subject'] = $cell;
						else 
							$groups[$col - 1]['lessons'][$day][$num]['cab'] = $cell;
					}
				} else {
					foreach(array_slice($row, 3, count($groups) * 2) as $col => $cell) {
						if($col % 2 == 0) 
							$groups[$col]['lessons'][$day][$num]['teacher'] = $cell;
						elseif($cell) 
							$groups[$col - 1]['lessons'][$day][$num]['cab'] = 
						isset($groups[$col - 1]['lessons'][$day][$num]['cab']) ? 
						implode(' / ', [$groups[$col - 1]['lessons'][$day][$num]['cab'], $cell]) : $cell;
					}
				}
			}

			foreach(array_filter($groups) as $group) {
				$weekDay = 0;
				foreach($group['lessons'] as $d => $day) { 
					$weekDay ++;
					foreach($day as $n => $lesson) {
						if(!$lesson['subject']) continue;
						$main = Schedule::updateOrCreate(
							[
								'group_id' => $group['group'],
								'year' => $request->year,
								'semestr' => $request->semestr,
								'day' => $weekDay,
								'num' => $n
							], 
							[
								'cab' => $lesson['cab'],
								'teacher' => trim($lesson['teacher']),
								'subject' => trim($lesson['subject'])
							]
						);
						$main->save();
					}
				}
			}
		}
		return redirect()->route('schedule', ['year' => $request->year, 'semestr' => $request->semestr]);
	}
}
