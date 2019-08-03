<?php
namespace Tests\Controllers;

use App\Comment;
use App\Store;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;

/**
 * @group StoreComment
 */
class StoreCommentTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * @test
     */
    public function it_can_show_all_comments_of_store()
    {
        $store  = factory('App\Store')
                        ->create();

        $userId   = factory('App\User')
                        ->create()
                        ->id;
        $noOfComments = 5;

        foreach (range(1,$noOfComments) as $index) {
           $comments[] = new Comment([
                'user_id' => $userId,
                'body'    => "Comment $index",
            ]);
        }

        $store->comments()->saveMany($comments);

        $response = $this->call('GET', "/store/$store->id/comments");

        $this->assertEquals(200, $response->status());
        $this->assertCount($noOfComments, $response->original);
    }

    /**
     * @test
     */
    public function it_can_add_comment_for_store()
    {
        $storeId  = factory('App\Store')
                        ->create()
                        ->id;

        $userId   = factory('App\User')
                        ->create()
                        ->id;

        $data = [
            'store_id' => $storeId,
            'user_id'  => $userId,
            'body'     => 'Comment message'
        ];

        $response = $this->call('POST', 'store/comment', $data);

        $this->assertEquals(201, $response->status());
        $this->seeInDatabase('comments', [
            'user_id' => $data['user_id'],
            'body'    => $data['body'],
        ]);
    }

    /**
     * @test
     */
    public function it_can_update_an_store_comment()
    {
        $store  = factory('App\Store')
                        ->create();

        $userId   = factory('App\User')
                        ->create()
                        ->id;

        $comment = new Comment([
            'user_id' => $userId,
            'body'    => 'This will need to edit.',
        ]);

        $comment = $store->comments()->save($comment);

        $data    = [
            'body' => 'Replacement for This will need to edit.'
        ];

        $response = $this->call('PUT', "/store/comment/$comment->id", $data);

        $this->assertEquals(200, $response->status());
        $this->seeInDatabase('comments', $data);
        $this->assertInstanceOf('App\Comment', $response->original['comment']);
    }

}
