<?php

Route::post('sms/register', 'SmsController@register');
Route::post('register', 'Controller@register');
Route::post('login', 'Api\Auth\LoginController@login');
Route::any('logout', 'Api\Auth\LoginController@logout');
