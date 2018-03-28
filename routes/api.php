<?php

Route::post('sms/register', 'SmsController@register');
Route::post('sms/resetPassword', 'SmsController@resetPassword');
Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('login', 'Api\Auth\LoginController@login');
Route::any('logout', 'Api\Auth\LoginController@logout');
