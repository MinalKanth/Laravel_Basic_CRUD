<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdvanceController;

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

Route::get('/', function () {
    return view('welcome');
});

//Route::resource('Register', RegistrationController::class);
Route::get('/', [RegistrationController::class, 'index']);

Route::get('/get_data', [RegistrationController::class, 'get']);

Route::post('/edit_data', [RegistrationController::class, 'edit']);

Route::post('/del_data', [RegistrationController::class, 'del']);

Route::post('/save_data', [RegistrationController::class, 'save']);
//
//Route::get('/state_by_country', [RegistrationController::class, 'state_by_country']);
//
//Route::get('/city_by_state', [RegistrationController::class, 'city_by_state']);

//Route::get('dropdown',[RegistrationController::class,'index']);
Route::post('api/fetch-state',[RegistrationController::class,'fatchState']);

Route::post('api/fetch-cities',[RegistrationController::class,'fatchCity']);

Route::get('index2', [AdvanceController::class, 'index2']);
