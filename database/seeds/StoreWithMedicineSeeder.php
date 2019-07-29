<?php

use App\Ingredient;
use Illuminate\Database\Seeder;

class StoreWithMedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Store', 20)->create();

        factory('App\Medicine', 30)->create();


        $medicines = App\Medicine::all();

        $index = 0;
        $medicines->each(function ($medicine) use(&$index) {
            $ingredient = new Ingredient(['name' => 'Sample Ingredient - ' . $index]);
            $medicine->ingredients()->save($ingredient);
            $index++;
        });

        App\Store::all()->each(function ($store) use ($medicines) {
        	$store->medicines()->attach(
        		$medicines->random(rand(1, 3))->pluck('id')->toArray()
        	);
        });
    }
}
