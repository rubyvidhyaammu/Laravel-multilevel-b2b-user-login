<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Distributor
Route::get('/distributors', [App\Http\Controllers\HomeController::class, 'distributors'])->name('distributors');
Route::get('/create-distributor', [App\Http\Controllers\HomeController::class, 'create_distributor'])->name('create.distributor');
Route::post('/create-distributor', [App\Http\Controllers\HomeController::class, 'store_distributor'])->name('create.distributor');

//Agent
Route::get('/agents', [App\Http\Controllers\HomeController::class, 'agents'])->name('agents');
Route::get('/create-agent', [App\Http\Controllers\HomeController::class, 'create_agent'])->name('create.agent');
Route::post('/create-agent', [App\Http\Controllers\HomeController::class, 'store_agent'])->name('create.agent');

//User
Route::get('/users', [App\Http\Controllers\HomeController::class, 'users'])->name('users');
Route::get('/create-user', [App\Http\Controllers\HomeController::class, 'create_user'])->name('create.user');
Route::post('/create-user', [App\Http\Controllers\HomeController::class, 'store_user'])->name('create.user');
Route::post('/agent-data', [App\Http\Controllers\HomeController::class, 'agent_data'])->name('agent.data');
