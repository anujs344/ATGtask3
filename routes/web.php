<?php

use App\Http\Controllers\RandLController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::guard('register')->check())
    {
        return redirect('/profile');
    }
    return view('login');
});

Route::get('/register',function(){
    if(Auth::guard('register')->check())
    {
        return redirect('/profile');
    }
    return view('register');
});
Route::post('/register/details',[RandLController::class,'registerdetials']);


Route::post('/login/details',[RandLController::class,'logindetials']);

// Route::get('/profile',function(){
    
//     return view('profile');

// })->middleware('profilecheck');

Route::get('/profile',[RandLController::class,'SendRelatedTask'])->middleware('profilecheck');

Route::get('/logout/profile',function(){
    if(Auth::guard('register')->check())
    {
        Auth::guard('register')->logout();
        return redirect('/');
    }
});

Route::post('/posts',[RandLController::class,'addwithapi']);
Route::post('/posts2',[RandLController::class,'updatewithapi']);