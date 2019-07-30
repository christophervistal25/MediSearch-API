<?php
namespace Tests\Controllers;

use App\Owner;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;

/**
 * @group Owner
 */
class OwnerTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    
    /**
     * Returning all the list of owners.
     * Why cause sometimes there are some co-owners 
     * @test
     */
    public function it_can_return_list_of_owners()
    {
        $owners = factory('App\Owner', 5)->create();

        $response = $this->call('GET', '/owners');
        $this->assertEquals(200, $response->status());
        $this->assertCount(5, $response->original);
    }

    /**
     * Requesting to Create/Register an Owner.
     * @test
     */
    public function it_can_create_a_owner()
    {
        /**
         * Adding a password in the owner array to complete the field since the 
         * password field is hidden in the model this will be not include when it comes to
         * making a owner in the factory method helper and converting it to array.
         * to check use the code below.
         * dd($owner);
         */
        
        $owner = factory('App\Owner')
                        ->make()
                        ->toArray();
        $owner['password'] = 123456;

        $response = $this->call('POST', '/owner', $owner);

        $this->assertEquals(201, $response->status());

        $this->seeJson([
            'fullname'   => $response->original['owner']->fullname,
            'email'      => $response->original['owner']->email,
            'contact_no' => $response->original['owner']->contact_no,
            'address'    => $response->original['owner']->address,
            'id'         => $response->original['owner']->id,
        ]);
    }

    /**
     * The owner can login
     * The default password in Ownerfactory is 1234
     * @test
     */
    public function it_can_login()
    {
        $owner = factory('App\Owner')->create();

        $response = $this->call('POST', '/owner/login', 
            ['email' => $owner->email , 'password' => 1234]
        );

        $this->assertEquals(200, $response->status());
        $this->seeJson(['success' => true, 'message' => 'Authorized.']);
    }

    /**
     * It will throw 422 for unrecognized owner.
     * The default password in Ownerfactory is 1234
     * @test
     */
    public function it_will_throw_422_for_wrong_credentials()
    {
        $owner = factory('App\Owner')->create();
        
        $response = $this->call('POST', '/owner/login', 
            ['email' => $owner->email , 'password' => 123]
        );

        $this->assertEquals(422, $response->status());
        $this->seeJson(['success' => false, 'message' => 'Please check your username or password.']);
    }

}
