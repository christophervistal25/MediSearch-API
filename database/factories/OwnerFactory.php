<?php
use Illuminate\Support\Facades\Hash;

$factory->define(App\Owner::class, function (Faker\Generator $faker) {
    return [
		'fullname'   => $faker->lastname,
		'email'      => $faker->email,
		'contact_no' => '09193693499',
		'address'    => 'Tandag Surigao del Sur',
		'password'   => Hash::make(1234),
    ];
});
