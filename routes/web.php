<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ChecksheetController;


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

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'postLogin']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    //Home Controller
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //Dropdown Controller
    Route::get('/dropdown', [DropdownController::class, 'index'])->middleware(['checkRole:IT']);
    Route::post('/dropdown/store', [DropdownController::class, 'store'])->middleware(['checkRole:IT']);
    Route::patch('/dropdown/update/{id}', [DropdownController::class, 'update'])->middleware(['checkRole:IT']);
    Route::delete('/dropdown/delete/{id}', [DropdownController::class, 'delete'])->middleware(['checkRole:IT']);

    //Rules Controller
    Route::get('/rule', [RulesController::class, 'index'])->middleware(['checkRole:IT']);
    Route::post('/rule/store', [RulesController::class, 'store'])->middleware(['checkRole:IT']);
    Route::patch('/rule/update/{id}', [RulesController::class, 'update'])->middleware(['checkRole:IT']);
    Route::delete('/rule/delete/{id}', [RulesController::class, 'delete'])->middleware(['checkRole:IT']);

    //User Controller
    Route::get('/user', [UserController::class, 'index'])->middleware(['checkRole:IT']);
    Route::post('/user/store', [UserController::class, 'store'])->middleware(['checkRole:IT']);
    Route::post('/user/store-partner', [UserController::class, 'storePartner'])->middleware(['checkRole:IT']);
    Route::patch('/user/update/{user}', [UserController::class, 'update'])->middleware(['checkRole:IT']);
    Route::get('/user/revoke/{user}', [UserController::class, 'revoke'])->middleware(['checkRole:IT']);
    Route::get('/user/access/{user}', [UserController::class, 'access'])->middleware(['checkRole:IT']);

    //Shop Master
    Route::get('/mst/shop', [ShopController::class, 'index'])->middleware(['checkRole:IT']);
    Route::post('/mst/shop/store', [ShopController::class, 'store'])->middleware(['checkRole:IT']);
    Route::patch('/mst/shop/update/{id}', [ShopController::class, 'update'])->middleware(['checkRole:IT']);
    Route::delete('/mst/shop/delete/{id}', [ShopController::class, 'delete'])->middleware(['checkRole:IT']);

    //Checksheet
    Route::get('/checksheet', [ChecksheetController::class, 'index'])->name('checksheet.index')->middleware(['checkRole:IT']);
    Route::post('/checksheet/store',[ChecksheetController::class, 'store'])->middleware(['checkRole:IT']);
    Route::get('/checksheet/form/{id}',[ChecksheetController::class, 'showForm'])->middleware(['checkRole:IT'])->name('form');
    Route::post('/checksheet/detail/store',[ChecksheetController::class, 'storeDetail'])->middleware(['checkRole:IT']);
    Route::get('/checksheet/detail/{id}', [ChecksheetController::class, 'detail'])->middleware(['checkRole:IT']);

});
