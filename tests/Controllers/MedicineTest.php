<?php
namespace Tests\Controllers;

use App\Ingredient;
use App\Medicine;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;

/**
 * @group Medicine
 */
class MedicineTest extends TestCase
{
    use DatabaseTransactions , DatabaseMigrations;

    /**
     * @test
     */
    public function it_can_update_a_ingredient()
    {
        $medicine = factory('App\Medicine')->create();
        $data     = factory('App\Medicine')->make()->toArray();
        $data['ingredients'][] = 'From sample 1 to sample 11';
        $data['ingredients'][] = 'From sample 2 to sample 22';
        $data['ingredients'][] = 'From sample 3 to sample 33';

        $medicine->addIngredients([
            'sample 1', 'sample 2', 'sample 3'
        ]);

        $response = $this->call('PUT', "/medicine/{$medicine->id}", $data);

        $this->assertEquals(200, $response->status());

        $this->seeInDatabase('ingredients', [
            'name' => 'From sample 1 to sample 11',
            'name' => 'From sample 2 to sample 22',
            'name' => 'From sample 3 to sample 33',
        ]);

        $this->seeInDatabase('medicines', [
            'name'        => $data['name'],
            'description' => $data['description'],
            'directions'  => $data['directions'],
            'quantity'    => $data['quantity'],
            'price'       => $data['price'],
        ]);
        
        $this->seeJson(['updated' => true]);
    }
}
