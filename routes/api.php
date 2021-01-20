<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

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

Route::middleware(['get.expiry'])->group(function () {
    Route::get('/getTechniques/{id}', [ApiController::class, 'getTechniques'])->where('id', '[0-9]+');
    Route::get('/getTechnique/{id}', [ApiController::class, 'getTechnique'])->where('id', '[0-9]+');
    Route::get('/getTactic/{id}', [ApiController::class, 'getTactic'])->where('id', '[0-9]+');
    });


