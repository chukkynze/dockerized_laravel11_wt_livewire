<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/projects', function () {
    return view('projects');
})->name('projects.listing');

Route::get('/projects/create', function () {
    return view('project-create-edit');
});

Route::get('/tasks', function () {
    return view('tasks');
})->name('tasks.listing');

Route::get('/tasks/create', function () {
    return view('task-create-edit');
});

Route::get('/projects/{uuid}/tasks', function () {
    return view('project');
});
