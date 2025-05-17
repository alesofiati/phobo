<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'users',
    'as' => 'user.',
], function () {

    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::post('/verify', [UserController::class, 'verify'])->name('verify');

});
