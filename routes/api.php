<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Candidates\CandidateController;
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

Route::group(['prefix' => 'v1'], function () {
    Route::post('/auth', [AuthController::class, 'login']);
    Route::group(['prefix' => 'auth', 'middleware' => 'jwt.verify'], function () {
        Route::get('/lead/{id}', [CandidateController::class, 'show'])->middleware('role:manager|agent');
        Route::get('/leads', [CandidateController::class, 'index'])->middleware('role:manager|agent');
        Route::post('/lead', [CandidateController::class, 'store'])->middleware('role:manager');
    });
});
