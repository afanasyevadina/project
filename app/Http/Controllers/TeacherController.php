<?php

namespace App\Http\Controllers;
use App\Teacher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function store(Request $request)
    {
        $teacher = Teacher::create($request->all());
        $teacher->save();
        return redirect()->route('teachers');
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::find($id);
        $teacher->fill($request->all());
        $teacher->save();
        return redirect()->route('teachers');
    }

    public function destroy($id)
    {
        $teacher = Teacher::find($id);
        $teacher->delete();
        return redirect()->route('teachers');
    }

    public function upload(Request $request)
    {
        $fileName = Storage::disk('public')->putFile('files', $request->file('file'));
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('public/storage/'.$fileName);
        $sheet = $spreadsheet->getActiveSheet();
        $list = $sheet->toArray();

        foreach (array_filter($list) as $key => $row) {
            $row = explode(' ', $row[0]);
            $teacher = Teacher::updateOrCreate([
                'surname' => $row[0], 
                'name' => $row[1],
                'patronymic' => @$row[2]
            ]);
            $teacher->save();
        }
        return redirect()->route('teachers');
    }
}
