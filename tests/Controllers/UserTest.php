<?php
namespace Tests\Controllers;

use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;
/**
 * @group User
 */
class UserTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * @test
     */
    public function it_can_login()
    {
        $user = factory('App\User')->create();

        $response = $this->call('POST', '/user/login', [
            'email'    => $user->email,
            'password' => 1234,
        ]);

        $this->assertEquals(200, $response->status());
        $this->seeJson(['login' => true, 'message' => 'Authorized']);
    }

    /**
     * @test
     */
    public function it_will_throw_a_422_for_wrong_credentials()
    {
        $user = factory('App\User')->create();

        $response = $this->call('POST', '/user/login', [
            'email'    => $user->email,
            'password' => 123,
        ]);

        $this->assertEquals(422, $response->status());
        $this->seeJson(['login' => false, 'message' => 'Please check your username or password']);
    }


    /**
     * @test
     */
    public function it_can_register()
    {
        $user = factory('App\User')->make()->toArray();
        $user['password'] = 123456;

        $response = $this->call('POST', '/user/register', $user);
        
        $this->assertEquals(201, $response->status());

        $this->seeInDatabase('users', [
            'fullname'   => $response->original->fullname,
            'email'      => $response->original->email,
            'contact_no' => $response->original->contact_no,
            'address'    => $response->original->address,
            'id'         => $response->original->id,
        ]);
    }

    /**
     * @test
     */
    public function it_can_show_user_profile()
    {
        $created = factory('App\User')->create();

        $response = $this->call('GET', "/user/$created->id");

        $this->assertEquals(200, $response->status());
        $this->seeJson([
            'fullname'   => $created->fullname,
            'email'      => $created->email,
            'contact_no' => $created->contact_no,
            'address'    => $created->address,
            'id'         => $created->id,
        ]);
    }

    /**
     * @test
     */
    public function it_can_update_user_profile()
    {
        $created = factory('App\User')->create();
        $data    = factory('App\User')->make();

        $response = $this->call('PUT', "/user/$created->id", $data->toArray());

        $this->assertEquals(200, $response->status());
        $this->seeInDatabase('users', $data->toArray());
        $this->seeJson(['updated' => true]);
    }
}
