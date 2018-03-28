<?php

Route::post('sms/register', 'SmsController@register');
Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('login', 'Api\Auth\LoginController@login');
Route::any('logout', 'Api\Auth\LoginController@logout');

Route::any('ws', 'WorkermanController@index');
Route::any('ws/send', 'WorkermanController@send');
