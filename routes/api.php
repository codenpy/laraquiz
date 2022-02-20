<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
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



Route::middleware('auth:sanctum')->get('/current-user', function (Request $request) {
    return $request->user();
});



Route::post('login', [AuthController::class, 'loginCheck']);


Route::post('user-register', [UserController::class, 'store']);
//Route::post('doctor', [DoctorController::class, 'store']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('quiz', [\App\Http\Controllers\Api\QuizController::class, 'index']);
    Route::get('quiz/{id}/edit', [\App\Http\Controllers\Api\QuizController::class, 'edit']);
    Route::put('quiz-option-selected/{id}', [\App\Http\Controllers\Api\QuizController::class, 'quizOptionSelected']);
    Route::get('result', [\App\Http\Controllers\Api\ResultController::class, 'index']);
    Route::post('result/add-result', [\App\Http\Controllers\Api\ResultController::class, 'addResult']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user', [\App\Http\Controllers\Api\UserController::class, 'index']);
    Route::get('user/create', [\App\Http\Controllers\Api\UserController::class, 'create']);
    Route::get('user/{id}/edit', [\App\Http\Controllers\Api\UserController::class, 'edit']);
    Route::put('user/{id}', [\App\Http\Controllers\Api\UserController::class, 'update']);
    Route::delete('user/{id}', [\App\Http\Controllers\Api\UserController::class, 'destroy']);

    Route::get('user-taken-quiz/{user_id}', [\App\Http\Controllers\Api\ResultController::class, 'userTakenQuiz']);
    Route::get('user-taken-quiz-result/{quiz_id}', [\App\Http\Controllers\Api\ResultController::class, 'userTakenQuizResult']);
    Route::post('logout', [\App\Http\Controllers\Api\UserController::class, 'logout']);
});



