<?php

use Dainsys\Locky\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
