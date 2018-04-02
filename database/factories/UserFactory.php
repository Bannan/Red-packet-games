<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'openid' => str_random(28),
        'mobile' => $faker->unique()->phoneNumber,
        'nickname' => $faker->name,
        'password' => bcrypt('secret'),
        'safety_code' => bcrypt('secret'),
        'balance' => rand(5, 999),
        'api_token' => str_random(64),
    ];
});
