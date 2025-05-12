<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\ApiAuthController;
use App\Http\Controllers\Api\Auth\ApiRegisterController;
use App\Http\Controllers\Api\Documents\ApiDocumentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', [ApiAuthController::class, 'auth']);
Route::post('/register', [ApiRegisterController::class, 'register']);
Route::post('/document/create',[ApiDocumentController::class, 'store'])->name('documents.store');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
