<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/projects',[ProjectController::class,"index"] )->name("projects.list");
Route::get('/projects/create',[ProjectController::class,"create"] )->name("projects.create");

Route::post('/projects/store',[ProjectController::class,"store"] )->name("projects.store");

Route::get('/works',[WorkController::class,"index"] )->name("works.list");

Route::get('/works/start',[WorkController::class,"start"] )->name("works.start");

Route::post('/works/start',[WorkController::class,"store"] )->name("works.store");


Route::post('/works/stop',[WorkController::class,"stop"] )->name("works.stop");

Route::get('/works/custom/stop',[WorkController::class,"customStop"] )->name("works.custom.stop");

Route::post('/works/custom/stop',[WorkController::class,"customStopStore"] )->name("works.custom.stop.store");
