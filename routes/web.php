<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;

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
    return redirect("login");
});

Route::get('/login', function () {
    if (session()->has("session_username")) {
        return redirect('home');
    }
    return view('login');
});

Route::post('/getlogin', [LoginController::class, 'login']);

Route::get('/logout', function () {
    if (session()->has("session_username")) {
        session()->pull("session_username");
    }
    return redirect('login');
});

Route::get('/add-student', function () {
    if (session()->has("session_username")) {
        return view('add-student', [StudentController::class, "loadView"]);
    }
    return redirect('login');
});

Route::get('/view-student', function () {
    if (session()->has("session_username")) {
        return view('view-student');
    }
    return redirect('login');
});

Route::get('/home', function () {
    if (session()->has("session_username")) {
        return view('home');
    }
    return redirect('login');
});

Route::post('/add-student', [StudentController::class, 'add']);
