<?php

use App\Http\Controllers\RTFEMController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [RTFEMController::class, 'index'])->name('index');
Route::put('/', [RTFEMController::class, 'create'])->name('create');
Route::post('/ocr', [RTFEMController::class, 'ocr'])->name('ocr');
Route::get('/{random}', [RTFEMController::class, 'view'])->name('view');
