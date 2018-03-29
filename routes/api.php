<?php

// 图形验证码
Route::get('captcha', 'Api\CaptchaController');

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
Route::get('games/{game}/screenings', 'Api\GameController@screenings');
Route::get('screenings/{screening}/packets', 'Api\ScreeningController@packets');

Route::get('test', function () {
    return App\Models\User::find(2)->childrenAll()->isEmpty();
});