<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


    Route::get('/',[MyController::class, 'UserCodeRandomNumber']);

    Route::get('Login-Page', function() {
        return view('login');
    })->name('Login-Page');

    Route::post('Registration', [MyController::class, 'Registration'])->name('PostRegistration');
