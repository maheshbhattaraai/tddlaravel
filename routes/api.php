<?php

use App\Http\Controllers\TodoListController;
use Illuminate\Support\Facades\Route;

Route::get('/todo-list',[TodoListController::class,'index']);
Route::get('/todo-list/{list}',[TodoListController::class,'show']);
Route::post('/todo-list',[TodoListController::class, 'store']);