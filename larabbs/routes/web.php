<?php

Route::get('/', 'TopicsController@index')->name('root');

// 用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login'); // 打开登录页面
Route::post('login', 'Auth\LoginController@login'); // form 表单登录
Route::post('logout', 'Auth\LoginController@logout')->name('logout'); // 退出登录

// 用户注册相关路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');// 打开注册页
Route::post('register', 'Auth\RegisterController@register'); // form 表单，注册

// 密码重置相关路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request'); // 打开发送邮箱页面
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset'); // 打开重置密码页面
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email 认证相关路由
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

//用户 资源路由
Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);

//话题 资源路由
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);

//话题分类 资源路由
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');

Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');

//评论 资源路由
Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);

Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);

Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');

//回复框里 艾特用户 throttle 中间件，限制访问速率 限制1分钟 20次
Route::get('at_user', 'UsersController@UserLikeSeach')->middleware('throttle:20000,1');