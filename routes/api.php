<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataStreamController;

Route::post('data-stream/analyze', [DataStreamController::class, 'dataStreamAnalyze'])->name('dataStreamAnalyze');