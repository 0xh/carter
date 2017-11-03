<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Tests\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: bcrypt('secret'),
        'remember_token' => null,
        'shopify_id' => null,
        'shopify_domain' => null,
        'shopify_token' => null,
        'shopify_scope' => null,
    ];
});