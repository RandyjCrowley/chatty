<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/login/{provider}', [App\Http\Controllers\AuthController::class, 'redirectToProvider']);
Route::get('/login/{provider}/callback', [App\Http\Controllers\AuthController::class, 'handleProviderCallback']);

Route::group(['middleware' => 'auth:sanctum'], function (): void {
    Route::post('chat', [App\Http\Controllers\ChatController::class, 'store']);
    Route::post('chat/{chat}', [App\Http\Controllers\ConversationController::class, 'store']);
    Route::get('user', function (Request $request) {
        return $request->user();
    });
});
