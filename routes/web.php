<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BallroomController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Entertainment;
use App\Http\Controllers\CustomerController;

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
    return view('dashboard', [
        'title' => 'Dashborad',
        'active' => 'dashboard'
    ]);
})->middleware('auth');

Route::get('dashboard', function () {
    return view('dashboard', [
        'title' => 'Dashborad',
        'active' => 'dashboard'
    ]);
})->middleware('auth');


//rooms
Route::get('rooms', [RoomController::class, 'index'])->middleware('auth');
Route::get('/rooms/create', [RoomController::class, 'create'])->middleware('auth');
Route::post('/rooms/create', [RoomController::class, 'store'])->middleware('auth');
Route::get('/rooms/update/{room_number}', [RoomController::class, 'edit'])->middleware('auth');
Route::post('/rooms/update/{room_number}', [RoomController::class, 'update'])->middleware('auth');
Route::post('/rooms/delete', [RoomController::class, 'delete'])->middleware('auth');

// ballroom
Route::get('ballrooms', [BallroomController::class, 'index']);

//login page
Route::get('login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'authenticate']);
Route::post('logout', [LoginController::class, 'logout']);

// register page
Route::get('register', [RegisterController::class, 'index']);
Route::post('register', [RegisterController::class, 'store']);

//customers
Route::get('customers', [CustomerController::class, 'index']);

// entertainment page
Route::get('entertainment', [Entertainment::class, 'index']);
Route::post('entertainment/create', [Entertainment::class, 'CreateEntertainment']);
