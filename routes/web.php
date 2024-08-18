<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/',[\App\Http\Controllers\HomeContronllers::class,'index'])->name('home');

Route::post('/buy-credits/webhook', [\App\Http\Controllers\CreditContronllers::class, 'webhook'])->name('credit.webhook');

Route::middleware(['auth','verified'])->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\DashboardContronllers::class,'index'])->name('dashboard');

    Route::get('/feature1', [\App\Http\Controllers\Feature1Contronllers::class, 'index'])->name('feature1.index');
    Route::post('/feature1', [\App\Http\Controllers\Feature1Contronllers::class, 'calculate'])->name('feature1.calculate');

    Route::get('/feature2', [\App\Http\Controllers\Feature2Contronllers::class, 'index'])->name('feature2.index');
    Route::post('/feature2', [\App\Http\Controllers\Feature2Contronllers::class, 'calculate'])->name('feature2.calculate');

    Route::get('/buy-credits', [\App\Http\Controllers\CreditContronllers::class, 'index'])->name('credit.index');
    Route::get('/buy-credits/success', [\App\Http\Controllers\CreditContronllers::class, 'success'])->name('credit.success');
    Route::get('/buy-credits/cancel', [\App\Http\Controllers\CreditContronllers::class, 'cancel'])->name('credit.cancel');

    Route::post('/buy-credits/{package}', [\App\Http\Controllers\CreditContronllers::class, 'buyCredits'])->name('credit.buy');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
