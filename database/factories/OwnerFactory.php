<?php

$factory->define(App\Owner::class, function (Faker\Generator $faker) {
    return [
		'fullname'   => $faker->name,
		'email'      => $faker->email,
		'contact_no' => '09193693499',
		'address'    => 'Tandag Surigao del Sur',
		'password'   => password_hash('1234', PASSWORD_DEFAULT),
    ];
});
