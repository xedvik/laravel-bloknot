<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Documents\WebDocumentController;
use App\Http\Controllers\Web\Auth\WebAuthController;
use App\Http\Controllers\Web\Auth\WebRegisterController;
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

Route::get('/', [WebDocumentController::class, 'index'])->name('main');
Route::get('/document/create', [WebDocumentController::class, 'create'])->name('document.create');
// Route::get('/document/{id}', [WebDocumentController::class, 'show']);
Route::post('/',[WebDocumentController::class, 'store'])->name('documents.store');
// Route::put('/document/{id}',[WebDocumentController::class, 'update']);
// Route::delete('/document/{id}',[WebDocumentController::class, 'destroy']);


Route::get('/login', [WebAuthController::class, 'index'])->name('login');
Route::post('/login', [WebAuthController::class, 'auth']);
Route::get('/register', [WebRegisterController::class, 'index'])->name('register');
Route::post('/register', [WebRegisterController::class, 'register']);
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');