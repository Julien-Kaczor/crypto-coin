<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/api/balance', 'KrakenController@getBalance')->name('api_balance_kraken');
Route::get('/api/trade/balance', 'KrakenController@getTradeBalance')->name('api_balance_trade_kraken');
Route::get('/api/market', 'KrakenController@getMarket')->name('api_market_kraken');