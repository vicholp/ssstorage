<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

Route::view('/', 'admin.index')->name('index');

Route::post('files/upload', [FileController::class, 'store'])->name('files.store');

Route::resource('files', FileController::class);
Route::resource('collections', CollectionController::class);

Route::get('logs', [LogViewerController::class, 'index'])->name('logs');
