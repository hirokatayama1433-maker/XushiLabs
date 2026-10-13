<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/inbox', function () {
    return view('inbox');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/ui-components/actions', function () {
    return view('UI_Components/Action');
});

Route::get('/ui-components/content', function () {
    return view('UI_Components/Content');
});
Route::get('/ui-components/data', function () {
    return view('UI_Components/Data');
});
Route::get('/ui-components/feedback', function () {
    return view('UI_Components/Feedback');
});
Route::get('/ui-components/forms', function () {
    return view('UI_Components/Form');
});
Route::get('/ui-components/navigation', function () {
    return view('UI_Components/Navigation');
});
Route::get('/ui-components/overlay', function () {
    return view('UI_Components/Overlay');
});