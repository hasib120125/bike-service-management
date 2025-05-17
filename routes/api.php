<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;

Route::apiResource('services', ServiceController::class);
Route::get('parts', [ServiceController::class, 'getParts']);
Route::get('parts-discount', [ServiceController::class, 'partsDiscount']);
