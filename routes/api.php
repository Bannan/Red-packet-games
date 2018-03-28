<?php

// SMS
Route::post('sms/register', 'SmsController@register');
Route::post('sms/reset/password', 'SmsController@reset');

// USER
Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('login', 'Api\Auth\LoginController@login');
Route::get('logout', 'Api\Auth\LoginController@logout');
Route::post('reset/password', 'Api\Auth\ResetPasswordController@reset');

// GAMES
Route::get('games', 'Api\GameController@index');