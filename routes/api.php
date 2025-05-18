<?php

use App\Http\Controllers\Api\RankingController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'users',
    'as' => 'user.',
], function () {

    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::post('/verify', [UserController::class, 'verify'])->name('verify');
});

Route::resource('rooms', RoomController::class)->only(['index', 'show', 'store', 'destroy']);
Route::get('ranking', [RankingController::class, '__invoke'])->name('rooms.index');
