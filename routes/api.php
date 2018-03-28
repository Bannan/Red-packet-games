<?php

Route::post('sms/register', 'SmsController@register');
Route::post('sms/reset/password', 'SmsController@reset');
Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('login', 'Api\Auth\LoginController@login');
Route::any('logout', 'Api\Auth\LoginController@logout');
Route::post('reset/password', 'Api\Auth\ResetPasswordController@reset');