<?php

namespace App\Http\Controllers\Admin;
use App\Teacher;
use App\Student;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends \App\Http\Controllers\Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::orderBy('role', 'asc')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.users.create');
    }
    public function register(Request $request)
    {
        $users = [];
        foreach($request->users as $uid) {
            $person = $request->role == 'teacher' ? Teacher::find($uid) : Student::find($uid);
            $user = User::where('person_id', $uid)
            ->where('role', $request->role)->first();
            if(!$user) $user = new User();
            $source = $request->role == 'teacher' ? $person->shortName : $person->name.' '.$person->surname;
            $user->name = str_replace('-', '_', str_slug($source));
            $user->email = $uid.$request->role.'@example.com';
            $password = str_random(10);
            $user->password = Hash::make($password);
            $user->api_token = str_random(60);
            $user->person_id = $uid;
            $user->role = $request->role;
            $user->save();
            $user->password = $password;
            $users[] = $user;
        }
        return view('admin.users.register', [
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $data['api_token'] = str_random(60);
        $user = User::create($data);
        return redirect()->route('admin/users');
    }
}
