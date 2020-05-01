<?php

namespace App\Http\Controllers;
use App\Subject;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubjectController extends Controller
{
    public function index()
    {
        return view('subject.index', [
            'subjects' => Subject::orderBy('name', 'asc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $subject = Subject::create($request->all());
        $subject->save();
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->fill($request->all());
        $subject->save();
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
    }

    public function upload(Request $request)
    {
        $fileName = Storage::disk('public')->putFile('files', $request->file('file'));
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('public/storage/'.$fileName);
        $sheet = $spreadsheet->getActiveSheet();
        $list = $sheet->toArray();

        foreach (array_filter($list) as $key => $row) {
            $subject = Subject::updateOrCreate(['name' => $row[0], 'name_kz' => @$row[1]]);
            $subject->save();
        }
        unlink('storage/app/public/'.$fileName);
        return redirect()->route('subjects');
    }
}
