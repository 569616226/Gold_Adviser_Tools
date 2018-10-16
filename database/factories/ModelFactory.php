<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->name,
        'email' => $faker->email,
        'name' => $faker->name,
        'office'  =>$faker->word,
        'tel'  => $faker->phoneNumber,
        'address' => $faker->word,
        'is_super' => '1',
        'fax' => $faker->phoneNumber,
        'code' => $faker->word,
        'trade' => $faker->word,
        'end_date' => $faker->dateTime,
        'aeo' => $faker->word,
        'trade_manual' => $faker->word,
        'main_trade' => $faker->word,
        'pro_item_type' => $faker->word,
        'capital' => $faker->word,
        'company_type' => $faker->word,
        'create_date' => $faker->dateTime,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->name,
        'email' => $faker->email,
        'name' => $faker->name,
        'office'  => $faker->word,
        'tel'  => $faker->phoneNumber,
        'is_super'  => 1,
        'password' => bcrypt('admin'),
        'remember_token' => str_random(10),
    ];
});