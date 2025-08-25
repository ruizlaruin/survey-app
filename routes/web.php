<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Survey Routes
Route::resource('surveys', SurveyController::class);
Route::get('surveys/{survey}/details', [SurveyController::class, 'show'])->name('surveys.show');

// Question Routes
Route::resource('questions', QuestionController::class);
Route::post('questions/mass-assign', [QuestionController::class, 'massAssign'])->name('questions.mass-assign');
Route::post('questions/mass-delete', [QuestionController::class, 'massDelete'])->name('questions.mass-delete');