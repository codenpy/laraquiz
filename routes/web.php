<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return redirect()->back()->with(['msg' => 'Cache Cleared', 'type' => 'success']);
});

Route::get('admin', [DashboardController::class, 'index'])->name('dashboard');
Route::post('auth/check', [DashboardController::class, 'authCheck'])->name('auth.check');


Route::get('quiz', [QuizController::class, 'index'])->name('quiz.index');
Route::get('quiz/create', [QuizController::class, 'create'])->name('quiz.create');
Route::post('quiz', [QuizController::class, 'store'])->name('quiz.store');
Route::get('quiz/{id}/edit', [QuizController::class, 'edit'])->name('quiz.edit');
Route::put('quiz/{id}', [QuizController::class, 'update'])->name('quiz.update');
Route::delete('quiz/{id}', [QuizController::class, 'destroy'])->name('quiz.destroy');

Route::get('question', [QuestionController::class, 'index'])->name('question.index');
Route::get('question/create', [QuestionController::class, 'create'])->name('question.create');
Route::post('question', [QuestionController::class, 'store'])->name('question.store');
Route::get('question/{id}/edit', [QuestionController::class, 'edit'])->name('question.edit');
Route::put('question/{id}', [QuestionController::class, 'update'])->name('question.update');
Route::delete('question/{id}', [QuestionController::class, 'destroy'])->name('question.destroy');
