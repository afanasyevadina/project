<?php

namespace App\Http\Controllers;
use App\Teacher;
use App\User;
use App\ExcelHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        return view('teacher.index', [
            'teachers' => Teacher::orderBy('surname', 'asc')
            ->orderBy('name', 'asc')
            ->orderBy('patronymic', 'asc')->get()
        ]);
    }

    public function create()
    {
        return view('teacher.create');
    }

    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('teacher.edit', [
            'teacher' => $teacher,
        ]);
    }

    public function view($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('teacher.view', [
            'teacher' => $teacher,
        ]);
    }

    public function store(Request $request)
    {
        $teacher = Teacher::create($request->all());
        $teacher->save();
        return redirect()->action('TeacherController@edit', ['id' => $teacher->id]);
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->fill($request->all());
        if($request->file('photo')) {
            $fileName = Storage::disk('public')->putFileAs('teachers', $request->file('photo'), $id);
            $teacher->photo = '/storage/app/public/'.$fileName;
        }
        $teacher->save();
        return redirect()->back();
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();
        return redirect()->action('TeacherController@index');
    }

    public function upload(Request $request)
    {
        $fileName = Storage::disk('public')->putFile('files', $request->file('file'));
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('storage/app/public/'.$fileName);
        $sheet = $spreadsheet->getActiveSheet();
        $list = $sheet->toArray();

        foreach (array_filter($list) as $key => $row) {
            if(@$row[0] && @$row[1]) {
                $teacher = Teacher::updateOrCreate([
                    'surname' => ExcelHelper::normalize($row[0]),
                    'name' => ExcelHelper::normalize($row[1]),
                    'patronymic' => @ExcelHelper::normalize($row[2]),
                    'born' => @date('Y-m-d', strtotime($row[3])),
                ]);
                $teacher->save();
            }
        }
        unlink('storage/app/public/'.$fileName);
        return redirect()->back();
    }
}
