<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/projects', function () {
    return view('projects');
});

Route::get('/projects/create', function () {
    return view('project-create');
});

Route::get('/tasks', function () {
    return view('tasks');
});

Route::get('/tasks/create', function () {
    return view('task-create');
});

Route::get('/projects/{uuid}/tasks', function () {
    return view('project');
});
