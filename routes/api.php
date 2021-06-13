<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManageUserController;
use Illuminate\Support\Facades\Route;

Route::post('/logout', [LoginController::class, 'logout'])
                ->middleware('auth:sanctum')
                ->name('logout');

Route::group(['prefix' => 'manage-user',  'middleware' => 'auth:sanctum'], function() {
    Route::get('', [ManageUserController::class, 'index']);
    Route::post('', [ManageUserController::class, 'store']);
    Route::put('{user}', [ManageUserController::class, 'update']);
    Route::delete('{user}', [ManageUserController::class, 'destroy']);
});
