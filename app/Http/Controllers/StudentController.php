<?php

namespace App\Http\Controllers;
use App\Student;
use App\Group;
use App\Pay;
use App\Specialization;
use App\Lang;
use App\ExcelHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $spec = \Request::get('spec');
        $kurs = \Request::get('kurs');
        $lang = \Request::get('lang');
        $pay = \Request::get('pay');
        $group = \Request::get('group');
        $base = \Request::get('base');
        $search = \Request::get('search');
        $students = Student::when($spec, function($query, $spec) {
            $query->whereHas('group', function($q) use($spec) {
                $q->where('specialization_id', $spec);
            });
        })
        ->when($kurs, function($query, $kurs) {
            $query->whereHas('group', function($q) use($kurs) {
                $q->where('kurs', $kurs);
            });
        })
        ->when($base, function($query, $base) {
            $query->whereHas('group', function($q) use($base) {
                $q->where('base', $base);
            });
        })
        ->when($lang, function($query, $lang) {
            $query->whereHas('group', function($q) use($lang) {
                $q->where('lang_id', $lang);
            });
        })
        ->when($pay, function($query, $pay) {
            $query->where('pay_id', $pay);
        })
        ->when($group, function($query, $group) {
            $query->where('group_id', $group);
        })
        ->when($search, function($query, $search) {
            $query->whereRaw("concat(surname,' ',name,' ',patronymic) like '%$search%'");
        })
        ->orderBy('surname', 'asc')
        ->orderBy('name', 'asc')
        ->orderBy('patronymic', 'asc')->paginate(100);
        return view('student.index', [
            'students' => $students,
            'groups' => Group::orderBy('name')->get(),
            'specializations' => Specialization::all(),
            'langs' => Lang::all(),
            'pays' => Pay::all(),
        ]);
    }

    public function create()
    {
        return view('student.create', [
            'groups' => Group::orderBy('name', 'asc')->get(),
            'pays' => Pay::orderBy('name', 'asc')->get(),
        ]);
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('student.edit', [
            'student' => $student,
            'groups' => Group::orderBy('name', 'asc')->get(),
            'pays' => Pay::orderBy('name', 'asc')->get(),
        ]);
    }

    public function view($id)
    {
        $student = Student::findOrFail($id);
        return view('student.view', [
            'student' => $student,
            'groups' => Group::orderBy('name', 'asc')->get(),
            'pays' => Pay::orderBy('name', 'asc')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $student = Student::create($request->all());
        $student->save();
        return redirect()->action('StudentController@edit', ['id' => $student->id]);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->fill($request->all());
        if($request->file('photo')) {
            $fileName = Storage::disk('public')->putFileAs('students', $request->file('photo'), $id);
            $student->photo = '/storage/app/public/'.$fileName;
        }
        $student->save();
        return redirect()->back();
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $group = $student->group_id;
        $student->delete();
        if(Student::where('group_id', $group)->count() < 25) {
            Student::where('group_id', $group)->update(['subgroup' => null]);
        }
        return redirect()->action('StudentController@index');
    }

    public function upload(Request $request)
    {
        $fileName = Storage::disk('public')->putFile('files', $request->file('file'));
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('storage/app/public/'.$fileName);
        $sheet = $spreadsheet->getActiveSheet();
        $list = $sheet->toArray();

        foreach (array_filter($list) as $key => $row) {
            if(@$row[0] && @$row[1]) {
                $student = Student::updateOrCreate([
                    'surname' => ExcelHelper::normalize($row[0]),
                    'name' => ExcelHelper::normalize($row[1]),
                    'patronymic' => @ExcelHelper::normalize($row[2]),
                    'born' => @date('Y-m-d', strtotime($row[3])),
                ]);
                $student->save();
            }
        }
        unlink('storage/app/public/'.$fileName);
        return redirect()->back();
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
    }
}
