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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Http\Controllers\Api'], function($api) {
	
	//用户注册
	$api->post('users', 'UsersController@store')->name('api.users.store');

	$api->group([
		'middleware' => 'api.throttle',
		'limit'      => 10,
		'expires'    => 1,
	], function($api) {
		//短信验证码
		$api->post('verificationCodes', 'verificationCodesController@store')->name('api.verificationCodes.store');
		//图形验证码
		$api->post('captchas', 'CaptchasController@index')->name('api.captchas.index');
	});
});

$api->version('v2', function($api) {
	$api->get('version', function() {
		return response('当前是v2版本');
	});
});