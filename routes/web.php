<?php

use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [CountryController::class, 'index']);
Route::post('add-country', [CountryController::class, 'store']);
Route::get('get-country', [CountryController::class, 'show']);
Route::post('countryDetails', [CountryController::class, 'edit']);
Route::post('updatecountryDetails', [CountryController::class, 'update']);
Route::post('deleteCountry', [CountryController::class, 'destroy']);
