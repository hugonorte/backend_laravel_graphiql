<?php

use Illuminate\Support\Facades\Route;
use MLL\GraphQLPlayground\GraphQLPlaygroundController;

Route::get('/playground', [GraphQLPlaygroundController::class, 'get']);

Route::get('/', function () {
    return view('welcome');
});
