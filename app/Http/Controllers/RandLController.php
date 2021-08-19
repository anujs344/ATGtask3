<?php

namespace App\Http\Controllers;

use App\Models\register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RandLController extends Controller
{
    public function registerdetials(Request $req)
    {
        $validated = $req->validate([
            'email' => 'required|unique:registers|max:255',
            'name' => 'required|regex:/^[a-zA-ZÑñ\s]+$/',
            'password' => 'required|min:8'
        ],
        [
            'email.required' => 'Field is Required','email.unique' => 'Already Registered','email.max' => 'More Than required length','email.email' => 'Must be in properformat',
            'name.required' => 'Field is Required','name.regex' => 'cannot be numeric',
            'password.required' => 'Field is Required','email.min' => 'Less than required length'
        ]);
        $register = new register();
        $register->name = $req->name;
        $register->password = Hash::make($req->password);
        $register->email = $req->email;
        $register->save();
        return redirect('/');
        
    }


    public function logindetials(Request $req)
    {
        $credentials = $req->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::guard('register')->attempt($credentials)) {

            $req->session()->regenerate();
            return redirect('/profile');
            
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
