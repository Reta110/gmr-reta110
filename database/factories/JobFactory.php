<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Job;
use App\User;
use Faker\Generator as Faker;

use function PHPSTORM_META\type;

$factory->define(Job::class, function (Faker $faker) {

    return [
        "title" => $faker->words(2, true),
        "command" => $faker->paragraph,
        "priority" => rand(0, 100)
    ];

});
