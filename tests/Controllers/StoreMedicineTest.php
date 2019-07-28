<?php
namespace Tests\Controllers;

use App\Medicine;
use App\Store;
use Illuminate\Database\Eloquent\Collection;
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
        $store = factory('App\Store')->create();
        $medicines = factory('App\Medicine', 5)->create()
                                                ->pluck('id')
                                                ->toArray();

        $store->medicines()->attach($medicines);
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
        $store = factory('App\Store')->create();
        $medicine = factory('App\Medicine')->make()
                                           ->toArray();

        $response = $this->call('POST', "/store/$store->id/medicine", $medicine);
        
        $this->assertEquals(201, $response->status());
        $this->seeInDatabase('medicines', $medicine);
        $this->seeJson(['created' => true]);
    }




}
