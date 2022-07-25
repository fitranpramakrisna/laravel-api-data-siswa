<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GradeController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\VerificationController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/create', [GradeController::class, 'store']);
Route::get('/show', [GradeController::class, 'index']);
Route::post('/update/{id}', [GradeController::class, 'update']);
Route::get('/delete/{id}', [GradeController::class, 'destroy']);

Route::get('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
