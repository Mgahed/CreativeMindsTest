<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CrudController;

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

Route::get('/home', function () {
    return view('home');
})->name('home');
Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth','UserRole']], function () {
    Route::get('index', [CrudController::class, 'index'])->name('crud.index');
    Route::get('create_form', [CrudController::class, 'create_form'])->name('crud.create_form');
    Route::post('create', [CrudController::class, 'create'])->name('crud.create');
    Route::get('update_form/{id}', [CrudController::class, 'update_form'])->name('crud.update_form');
    Route::post('update/{id}', [CrudController::class, 'update'])->name('crud.update');
    Route::get('delete/{id}', [CrudController::class, 'delete'])->name('crud.delete');
});
