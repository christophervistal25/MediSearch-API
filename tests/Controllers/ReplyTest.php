<?php
namespace Tests\Controllers;

use App\Comment;
use App\Reply;
use App\Store;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;

/**
 * @group CommentReply
 */
class ReplyTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * @test
     */
    public function it_can_reply_to_a_comment()
    {
        $store        = factory('App\Store')->create();
        $userId       = factory('App\User')->create()->id;
        $userReplyId  = factory('App\User')->create()->id;

        $data               = ['user_id' => $userId, 'body' => 'Sample Body'];
        $comment            = $store->comments()->save(new Comment($data));
        $data['comment_id'] = $comment->id;

        $response = $this->call('POST', '/comment/reply', $data);

        $this->assertEquals(201, $response->status());
        $this->seeInDatabase('replies', $data);
    }

    /**
     * @test
     */
    public function it_can_update_a_reply()
    {
        $store        = factory('App\Store')->create();
        $userId       = factory('App\User')->create()->id;
        $userReplyId  = factory('App\User')->create()->id;

        $data               = ['user_id' => $userId, 'body' => 'Sample Body'];
        $comment            = $store->comments()->save(new Comment($data));
        $reply = $comment->replies()->save(new Reply($data));
        $data  = ['body' => 'Replacement for (Sample Body)'];

        $response = $this->call('PUT', "/comment/reply/$reply->id", $data);

        $this->assertEquals(200, $response->status());
        $this->assertInstanceOf('App\Reply', $response->original);
        $this->seeInDatabase('replies', $data);
    }
}
