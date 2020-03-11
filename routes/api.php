<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Eload Api Documentation
Route::post('Token','api\token_controller@index');
Route::post('topup/test','api\topup_controller@topup_test');
Route::post('enquiry/test','api\enquiry_controller@enquiry_test');
Route::post('package/buy/test','api\package_buy_controller@package_buy');
Route::post('package/package/list','api\package_list_controller@package_list');
Route::post('balance','api\balance_controller@balance');
// End Eload Api Documentation

// Local Prepaid Card Api Documentation
Route::post('prepaid/Token','prepaid\token_controller@index');
Route::post('prepaid/buy/card/test','prepaid\buy_card_controller@buy_card');
Route::post('prepaid/enquiry','prepaid\enquiry_controller@enquiry');
Route::post('prepaid/selling/price','prepaid\selling_price_controller@selling_price');
Route::post('prepaid/stock','prepaid\stock_controller@stock');
Route::post('prepaid/balance','prepaid\balance_controller@balance');
Route::post('prepaid/exchange/rate','prepaid\exchange_rate_controller@exchange_rate');
Route::post('prepaid/discount/rate','prepaid\discount_rate_controller@discount_rate');

//End Local Prepaid Card Api Documentation

Route::group(['prefix' => 'api', 'middleware' => 'throttle:'.env('RATE_LIMIT')*2.,'100'], function () {
Route::get('a','api\balance_controller@test');
Route::get('b','api\balance_controller@test');
Route::get('c','api\balance_controller@test');
Route::get('d','api\balance_controller@test');
Route::get('e','api\balance_controller@test');
Route::get('f','api\balance_controller@test');
Route::get('g','api\balance_controller@test');
Route::get('h','api\balance_controller@test');
});