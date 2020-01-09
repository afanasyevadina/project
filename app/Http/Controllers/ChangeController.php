<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Change;
use App\Department;
use App\Lang;
use App\Group;
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

	public function upload(Request $request)
	{
		$fileName = Storage::disk('public')->putFile('files', $request->file('file'));
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('public/storage/'.$fileName);
		$list = $spreadsheet->getActiveSheet()->toArray();
		$list = array_slice($list, 5);
		$groups = [];
		$str = 0;
		$source = collect(Group::all()->pluck('name'))->combine(Group::all()->pluck('id'));
		foreach ($list as $key => $row) {
			if(strpos($row[2], '№') !== false) {
				$str = $key;
				foreach(array_slice($row, 3) as $col => $cell) {
					if($col % 2 == 0 && $cell) {
						if(isset($source[$cell]))
							$groups[$str][$col]['group'] = $source[$cell];
						else {
							echo "Undefined ".$cell; return;
						}
					}
				}
			} else {
				$num = $row[2];
				if($num) {
					$row = array_slice($row, 3);
					foreach($row as $col => $cell) {
						if($col % 2 == 0 && $cell) {
							$groups[$str][$col]['lessons'][$num]['subject'] = $cell;
						} elseif(@$row[$col - 1]) {
							$groups[$str][$col - 1]['lessons'][$num]['cab'] = $cell;
						}
					}
				}
			}
		}
		foreach ($groups as $row) {
			foreach ($row as $group) {
				if(!@$group['group']) continue;
				foreach ($group['lessons'] as $num => $lesson) {
					if(!@$lesson['subject']) continue;
					$change = Change::updateOrCreate(
						[
							'group_id' => $group['group'],
							'day' => $request->date,
							'num' => $num
						],
						[
							'subject' => $lesson['subject'],
							'cab' => $lesson['cab'],
						]
					);
					if(
						strpos($lesson['subject'], 'сабақ кестесі бойынша') !== false || 
						strpos($lesson['subject'], 'урок по основному расписанию') !== false
					) $change->is_main = 1;
					$change->save();
				}
			}
		}
		return redirect()->route('changes', ['date' => $request->date]);
	}

}
