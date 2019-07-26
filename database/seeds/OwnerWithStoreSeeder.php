<?php

use Illuminate\Database\Seeder;

class OwnerWithStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Store', 20)->create();

        factory('App\Owner', 30)->create();

        $stores = App\Store::all();

        App\Owner::all()->each(function ($owner) use ($stores) {
        	$owner->stores()->attach(
        		$stores->random(rand(1, 3))->pluck('id')->toArray()
        	);
        });
    }
}
