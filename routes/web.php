<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatatableController;

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

// Route::get('/', function () {
    
//     return view('welcome');
// });
Route::get('/all-data-display',[DatatableController::class,'allData']);
Route::get('/all-data', [DatatableController::class,'data'])->name('users.data');
Route::post('/store-data', [DatatableController::class,'store'])->name('store.data');
Route::get('/delete-data/{id}', [DatatableController::class,'delete'])->name('delete.data');
Route::get('/edit-data/{id}', [DatatableController::class,'edit'])->name('edit.data');
Route::post('/update-data/{id}', [DatatableController::class,'update'])->name('update.data');
