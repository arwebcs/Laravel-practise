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

/*************************************** LOGIN AND LOGOUT *************************************** */
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
/*************************************** LOGIN AND LOGOUT *************************************** */

/************************************GROUP MIDDLEWARES *************************************** */
Route::group(["middleware" => ["protectedPages"]], function () {
    Route::view("home", "home");
    Route::get('/add-student', [StudentController::class, "loadView"]);
    Route::post('/add-student', [StudentController::class, 'add']);
    Route::get('/edit-student/{studentId}', [StudentController::class, "getStudent"]);
    Route::post('/edit-student/{studentId}', [StudentController::class, "update"]);
    Route::get('/delete-student/{studentId}', [StudentController::class, "deleteStudent"]);
    Route::get('/view-student', [StudentController::class, "viewStudents"]);
});
/************************************GROUP MIDDLEWARES *************************************** */
