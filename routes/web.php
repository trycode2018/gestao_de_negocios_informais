<?php

use Illuminate\Support\Facades\Route;


// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('transactions', TransactionController::class);
    Route::resource('categories', CategoryController::class);
    
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});
