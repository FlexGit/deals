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

Route::group(['middleware' => [/*'filterIp'*/]], function () {
	Auth::routes(['register' => false]);
	
	Route::group(['middleware' => ['auth']], function () {
		/* Deal */
		Route::get('/', [App\Http\Controllers\DealController::class, 'getDeals'])->name('deal-index');
		Route::get('/deal-list', [App\Http\Controllers\DealController::class, 'getList'])->name('deal-list');
		Route::get('/deal/{id?}', [App\Http\Controllers\DealController::class, 'edit'])->name('deal-edit');
		Route::post('/deal/save', [App\Http\Controllers\DealController::class, 'save'])->name('deal-save');
		Route::delete('/deal/{id}', [App\Http\Controllers\DealController::class, 'delete'])->name('deal-delete');
		Route::get('/deal/{id}/print/specification', [App\Http\Controllers\DealController::class, 'printSpecification'])->name('specification-print');
		Route::get('/deal/{id}/print/worksheet', [App\Http\Controllers\DealController::class, 'printWorksheet'])->name('worksheet-print');
		Route::delete('/deal/{id}/file/{name}/{ext}', [App\Http\Controllers\DealController::class, 'deleteFile'])->name('file-delete');
		Route::get('/file/{ext}/{name}', [App\Http\Controllers\DealController::class, 'getFile'])->name('deal-file');
		
		/* Passport */
		Route::get('/contractor/{id}/passport/{passport_id}/get', [App\Http\Controllers\ContractorController::class, 'getPassport'])->name('passport-get');
		Route::get('/contractor/{id}/passport/{passport_id?}', [App\Http\Controllers\ContractorController::class, 'editPassport'])->name('passport-edit');
		Route::post('/contractor/{id}/passport-save', [App\Http\Controllers\ContractorController::class, 'savePassport'])->name('passport-save');
		Route::delete('/contractor/{id}/passport/{passport_id}', [App\Http\Controllers\ContractorController::class, 'deletePassport'])->name('passport-delete');
		Route::get('/contractor/{id}/passport/{ext}/{name}', [App\Http\Controllers\ContractorController::class, 'getPassportFile'])->name('contractor-passport');

		/* Contractor */
		Route::get('/contractors', [App\Http\Controllers\ContractorController::class, 'getContractors'])->name('contractor-index');
		Route::get('/contractor-list', [App\Http\Controllers\ContractorController::class, 'getList'])->name('contractor-list');
		Route::get('/contractor/{id?}', [App\Http\Controllers\ContractorController::class, 'edit'])->name('contractor-edit');
		Route::post('/contractor/search', [App\Http\Controllers\ContractorController::class, 'search'])->name('contractor-search');
		Route::post('/contractor/save', [App\Http\Controllers\ContractorController::class, 'save'])->name('contractor-save');
		Route::delete('/contractor/{id}', [App\Http\Controllers\ContractorController::class, 'delete'])->name('contractor-delete');

		/* Coins */
		Route::get('/coins', [App\Http\Controllers\CoinController::class, 'getCoins'])->name('coin-index');
		Route::get('/coin-list', [App\Http\Controllers\CoinController::class, 'getList'])->name('coin-list');
		Route::get('/coin/{id?}', [App\Http\Controllers\CoinController::class, 'edit'])->name('coin-edit');
		Route::post('/coin/search', [App\Http\Controllers\CoinController::class, 'search'])->name('coin-search');
		Route::post('/coin/save', [App\Http\Controllers\CoinController::class, 'save'])->name('coin-save');
		Route::delete('/coin/{id}', [App\Http\Controllers\CoinController::class, 'delete'])->name('coin-delete');
		
		/* Legal Entities */
		Route::get('/legal-entities', [App\Http\Controllers\LegalEntityController::class, 'getLegalEntities'])->name('legal-entity-index');
		Route::get('/legal-entity-list', [App\Http\Controllers\LegalEntityController::class, 'getList'])->name('legal-entity-list');
		Route::get('/legal-entity/{id?}', [App\Http\Controllers\LegalEntityController::class, 'edit'])->name('legal-entity-edit');
		Route::post('/legal-entity/save', [App\Http\Controllers\LegalEntityController::class, 'save'])->name('legal-entity-save');
		Route::delete('/legal-entity/{id}', [App\Http\Controllers\LegalEntityController::class, 'delete'])->name('legal-entity-delete');
	});
});

Route::fallback(function () {
	abort(404);
});
