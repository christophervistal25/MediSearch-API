<?php
namespace Tests\Controllers;

use App\Ingredient;
use App\Medicine;
use App\Store;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;

/**
 * @group StoreMedicine
 */
class StoreMedicineTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * List all medicine of a selected store.
     * @test
     */
    public function it_can_list_all_medicine()
    {
        $store     = factory('App\Store')->create();
        $medicines = factory('App\Medicine', 5)->create()->each(function ($medicine) {
             $medicine->ingredients()->save(
                new Ingredient(['name' => 'Sample Medicine Ingredient'])
            );
        });

        $store->medicines()->attach($medicines->pluck('id')->toArray());

        $response = $this->call('GET', "/store/$store->id/medicines");
        
        $this->assertEquals(200, $response->status());
        $this->assertCount(5, $response->original['data']);

    }

    /**
     * Entry a medicine to a store
     * @test
     */
    public function it_can_entry_a_medicine_to_store()
    {
        $store    = factory('App\Store')->create();
        $medicine = factory('App\Medicine')->make()
                                           ->toArray();
        $medicine['ingredients'][] = 'Ingredient 1';
        $medicine['ingredients'][] = 'Ingredient 2';

        $response = $this->call('POST', "/store/$store->id/medicine", $medicine);

        $this->assertEquals(201, $response->status());
        $this->seeInDatabase('medicines', [
            'name'        => $medicine['name'],
            'description' => $medicine['description'],
            'directions'  => $medicine['directions'],
            'quantity'    => $medicine['quantity'],
            'price'       => $medicine['price'],
        ]);

        $this->seeJson(['created' => true]);
    }

}
