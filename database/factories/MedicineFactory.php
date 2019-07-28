<?php


$factory->define(App\Medicine::class, function (Faker\Generator $faker) {
    return [
		'name'        => $faker->word,
		'description' => $faker->sentence,
		'directions'  => $faker->paragraph,
		'quantity'    => $faker->numberBetween(1,10),
		'price'       => $faker->randomFloat(2, 10, 100),
    ];
});


