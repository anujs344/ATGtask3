<?php

namespace App\Http\Controllers;

use App\Models\register;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use \GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use PhpParser\Node\Stmt\Catch_;

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

    public function SendRelatedTask()
    {
        $count = Task::where('user_id',Auth::guard('register')->user()->id)->count();
        return view('profile')->with(['tasks'=>Task::where('user_id',Auth::guard('register')->user()->id)->get()])->with('totaltask',$count);
    }

    public function addwithapi(Request $req)
    {
        $request = Request::create('/api/todo/add','POST',['task'=>$req->input('task'),'user_id'=>$req->input('user_id')]);
        $request->headers->set('APP_KEY', 'helloatg');
        $response = json_decode(Route::dispatch($request)->getContent());
        return $response;
    }

    public function updatewithapi(Request $req)
    {
        $request = Request::create('/api/todo/status','POST',['task_id'=>$req->input('task_id'),'status'=>$req->input('status')]);
        $request->headers->set('APP_KEY', 'helloatg');
        $response = json_decode(Route::dispatch($request)->getContent());
        return $response;
    }

}
