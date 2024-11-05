<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/login/{provider}', [App\Http\Controllers\AuthController::class, 'redirectToProvider']);
Route::get('/login/{provider}/callback', [App\Http\Controllers\AuthController::class, 'handleProviderCallback']);

Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function (): void {
    Route::get('/', function (Request $request) {
        return $request->user();
    });
});
