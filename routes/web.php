<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate;

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

Route::group(['middleware' => ['filterIp']], function () {
	Auth::routes(/*['register' => false]*/);
	
	Route::group(['middleware' => ['auth']], function () {
		/* Deal */
		Route::get('/', [App\Http\Controllers\DealController::class, 'getDeals'])->name('deal-index');
		Route::get('/deal-list/', [App\Http\Controllers\DealController::class, 'getList'])->name('deal-list');
		Route::get('/deal/{id?}', [App\Http\Controllers\DealController::class, 'edit'])->name('deal-edit');
		Route::post('/deal/save', [App\Http\Controllers\DealController::class, 'save'])->name('deal-save');
		Route::delete('/deal/{id}', [App\Http\Controllers\DealController::class, 'delete'])->name('deal-delete');
		Route::get('/deal/{id}/print/specification', [App\Http\Controllers\DealController::class, 'printSpecification'])->name('specification-print');
		Route::get('/deal/{id}/print/worksheet', [App\Http\Controllers\DealController::class, 'printWorksheet'])->name('worksheet-print');

		/* Contractor */
		Route::get('/contractors/', [App\Http\Controllers\ContractorController::class, 'getContractors'])->name('contractor-index');
		Route::get('/contractor-list/', [App\Http\Controllers\ContractorController::class, 'getList'])->name('contractor-list');
		Route::get('/contractor/{id?}', [App\Http\Controllers\ContractorController::class, 'edit'])->name('contractor-edit');
		Route::post('/contractor/search', [App\Http\Controllers\ContractorController::class, 'search'])->name('contractor-search');
		Route::get('/file/{ext}/{name}', [App\Http\Controllers\ContractorController::class, 'getFile'])->name('contractor-file');
		Route::post('/contractor/save', [App\Http\Controllers\ContractorController::class, 'save'])->name('contractor-save');
		Route::delete('/contractor/{id}', [App\Http\Controllers\ContractorController::class, 'delete'])->name('contractor-delete');

		/* Coins */
		Route::get('/coins/', [App\Http\Controllers\CoinController::class, 'getCoins'])->name('coin-index');
		Route::get('/coin-list/', [App\Http\Controllers\CoinController::class, 'getList'])->name('coin-list');
		Route::get('/coin/{id?}', [App\Http\Controllers\CoinController::class, 'edit'])->name('coin-edit');
		Route::post('/coin/search', [App\Http\Controllers\CoinController::class, 'search'])->name('coin-search');
		Route::post('/coin/save', [App\Http\Controllers\CoinController::class, 'save'])->name('coin-save');
		Route::delete('/coin/{id}', [App\Http\Controllers\CoinController::class, 'delete'])->name('coin-delete');
	});
});

Route::fallback(function () {
	abort(404);
});
