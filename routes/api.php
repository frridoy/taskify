<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::get('/users', [UserController::class, 'getAllUsers']);

Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});
