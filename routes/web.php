<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DocumentController::class, 'index'])->name('main');
Route::get('/document/create', [DocumentController::class, 'create'])->name('document.create');
// Route::get('/document/{id}', [DocumentController::class, 'show']);
Route::post('/',[DocumentController::class, 'store'])->name('documents.store');
// Route::put('/document/{id}',[DocumentController::class, 'update']);
// Route::delete('/document/{id}',[DocumentController::class, 'destroy']);