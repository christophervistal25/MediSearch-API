<?php

$factory->define(App\Store::class, function (Faker\Generator $faker) {
    return [
		'name'       => $faker->name,
		'located_at' => $faker->address,
    ];
});
