<?php

namespace App\Http\Controllers;
use App\Student;
use App\Group;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index($id)
    {
        $subgroup = \Request::get('subgroup');
        $students = Student::where('group_id', $id);
        if($subgroup) $students->where('subgroup', $subgroup);
        return view('student.index', [
            'students' => $students
            ->orderBy('surname', 'asc')
            ->orderBy('name', 'asc')
            ->orderBy('patronymic', 'asc')->get(),
            'group' => Group::find($id),
            'groups' => Group::all()
        ]);
    }

    public function store(Request $request)
    {
        $student = Student::create($request->all());
        $student->save();
        return redirect()->route('students', ['id' => $student->group_id]);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        $group = $student->group_id;
        $student->fill($request->all());
        $student->save();
        return redirect()->route('students', ['id' => $group]);
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        $group = $student->group_id;
        $student->delete();
        if(Student::where('group_id', $group)->count() < 25) {
            Student::where('group_id', $group)->update(['subgroup' => null]);
        }
        return redirect()->route('students', ['id' => $group]);
    }

    public function upload(Request $request)
    {
        $fileName = Storage::disk('public')->putFile('files', $request->file('file'));
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('public/storage/'.$fileName);
        $sheet = $spreadsheet->getActiveSheet();
        $list = $sheet->toArray();

        foreach (array_filter($list) as $key => $row) {
            $row = explode(' ', $row[0]);
            $student = Student::updateOrCreate([
                'surname' => $row[0], 
                'name' => $row[1],
                'patronymic' => @$row[2],
                'group_id' => $request->group,
            ]);
            $student->save();
        }
        return redirect()->route('students', ['id' => $request->group]);
    }

    public function divide($group)
    {
        $students = Student::where('group_id', $group)
        ->orderBy('surname', 'asc')
        ->orderBy('name', 'asc')
        ->orderBy('patronymic', 'asc')->get();
        $half = count($students) / 2;
        foreach($students as $key => $student) {
            $student->subgroup = $key < $half ? 1 : 2;
            $student->save();
        }
        return redirect()->back();
    }
}
