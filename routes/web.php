<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkripsiController;

Route::get('/skripsi', function () {
    return view('skripsi.index'); 
    });
Route::get('/skripsi', [SkripsiController::class, 'index']);
