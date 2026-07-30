<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-csrf', function () {
    return 'CSRF: [' . csrf_token() . '] Session: [' . session()->getId() . ']';
});

Route::get('/', function () {
    return redirect('/admin');
});
