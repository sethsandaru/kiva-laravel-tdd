<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);

        // Notes
        Route::resource('notes', NoteController::class)->except([
            'create', 'edit'
        ]);

        // Images
        Route::resource('images', ImagesController::class)->except([
            'create', 'edit'
        ]);
    });
});
