<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.listing');
Route::get('/projects/create', [ProjectController::class, 'create']);
Route::get('/projects/{uuid}/edit', [ProjectController::class, 'edit']);


Route::get('/tasks', function () {
    return view('task.datatable-listing');
})->name('tasks.listing');

Route::get('/tasks/create', function () {
    return view('task.create');
});

Route::get('/tasks/{uuid}/edit', function () {
    return view('task.edit');
});

//Route::get('/projects/{uuid}/tasks', function () {
//    return view('project');
//});
