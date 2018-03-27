<?php

Route::post('register', 'SmsController@register');

Route::post('login', 'Api\Auth\LoginController@login');
Route::any('logout', 'Api\Auth\LoginController@logout');
