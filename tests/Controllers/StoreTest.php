<?php
namespace Tests\Controllers;

use App\Store;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;

class StoreTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    
    /**
     * The store can store a new Store
     * @test
     * @return [type] [description]
     */
    public function it_can_create_a_store()
    {
        $store = factory('App\Store')
                    ->make()
                    ->toArray();

        $response = $this->call('POST', '/owner/store', $store);

        $this->assertEquals(201, $response->status());
        $this->seeInDatabase('stores', $store);
        $this->seeJson(['created' => true]);
    }

    /**
     * @test
     */
    public function it_can_update_a_store()
    {
        $store = factory('App\Store')->create();

        $response = $this->call('PUT', '/owner/store/'. $store->id, $store->toArray());
        
        $this->assertEquals(200, $response->status());
        $this->seeJson(['updated' => true]);
        $this->seeInDatabase('stores', $store->toArray());
    }
}
