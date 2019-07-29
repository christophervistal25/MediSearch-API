<?php
namespace Tests\Controllers;

use App\Owner;
use App\Store;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;

/**
 * @group OwnerStore
 */
class OwnerStoreTest extends TestCase
{
     use DatabaseMigrations, DatabaseTransactions;

     /**
      * @test
      */
     public function it_can_display_all_store()
     {
        $owner = factory('App\Owner')->create();
        $stores = factory('App\Store', 5)->create()
                                    ->pluck('id')
                                    ->toArray();

        $owner->stores()->attach($stores);
        $response = $this->call('GET', "/owner/$owner->id/stores");

        $this->assertEquals(200, $response->status());
        $this->assertCount(5, $response->original['stores']);
     }

    /**
     * @test
     */
    public function it_can_add_a_store()
    {
        $owner = factory('App\Owner')->create();
        $store = factory('App\Store')->make()
                                    ->toArray();

        $response = $this->call('POST', "/owner/$owner->id/store", $store);
        $this->assertEquals(201, $response->status());
        $this->seeInDatabase('stores', $store);
        $this->seeJson(['created' => true]);
    }

    /**
     * @test
     */
    public function it_can_assign_a_pharmacist()
    {
        $owner      = factory('App\Owner')->create();
        $store      = factory('App\Store')->create();
        $pharmacist = factory('App\Pharmacist')->make()->toArray();

        $owner->stores()->attach($store->id);
        $response = $this->call('POST', "/owner/$owner->id/store/$store->id", $pharmacist);

        $this->assertEquals(201, $response->status());
    }

}
