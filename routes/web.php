<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home',['title' => 'Home page']);
});
Route::get('/developer', function () {
    return view('developer',['title' => 'Developer']);
});
Route::get('/Chatbot', function () {
    return view('Chatbot',['title' => 'chat bot']);
});

Route::get('/contact', function () {
    return view('contact',['title' => 'contact']);
});
