<?php

use Illuminate\Support\Facades\Route;
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
// */

// Route::get('/', function () {
//     return view('index');
// });


Route::resource('/ajax', StudentController::class);
Route::get('/data',[StudentController::class,'readData'])->name('readData');


// Route::get('/ajax',[StudentController::class,'show'])->name('ajaxShow');
