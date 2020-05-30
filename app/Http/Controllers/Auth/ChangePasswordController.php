<?php

namespace App\Http\Controllers\Auth;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends \App\Http\Controllers\Controller
{
    public function edit()
    {
        return view('auth.passwords.change');
    }

    public function update(Request $request)
    {
        $request->validate([
            'old_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        if(!Hash::check($request->old_password, \Auth::user()->password)) {
            return redirect()->back()->withInput()
            ->withErrors(['old_password'=>['The password is incorrect']]);
        }
        \Auth::user()->password = Hash::make($request->password);
        \Auth::user()->save();
        return redirect('/');
    }
}
