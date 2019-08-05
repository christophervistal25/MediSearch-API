<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
        	OwnerSeeder::class,
            // PharmacistSeeder::class,
            OwnerWithStoreSeeder::class,
            StoreWithMedicineSeeder::class,
            // StoreCommentSeeder::class,
        ]);
    }
}
