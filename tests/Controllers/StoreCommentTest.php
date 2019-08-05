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
     * Refactor by making a dataprovider.
     * [Helper for generating dummy comment.]
     * @param  int    $userId       [description]
     * @param  int    $noOfComments [description]
     * @return [type]               [description]
     */
    private function commentStub(int $userId, int $noOfComments)
    {
        if ($noOfComments > 1) {
            foreach (range(1,$noOfComments) as $index) {
                $comments[] = new Comment(['user_id' => $userId, 'body'    => "Comment $index"]);
            }    
            return $comments;
        }
        return new Comment(['user_id' => $userId, 'body' => 'Sample Comment']);
    }

    /**
     * @test
     */
    public function it_can_show_all_comments_of_store()
    {
        $noOfComments = 5;
        $store        = factory('App\Store')->create();
        $userId       = factory('App\User')->create()->id;
        $comments     = $this->commentStub($userId, $noOfComments);

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
        $storeId = factory('App\Store')->create()->id;
        $userId  = factory('App\User')->create()->id;
        $data    = ['store_id' => $storeId, 'user_id' => $userId, 'body' => 'Comment message'];

        $response = $this->call('POST', 'store/comment', $data);

        $this->assertEquals(201, $response->status());
        $this->seeInDatabase('comments', ['user_id' => $data['user_id'], 'body' => $data['body'] ]);
    }

    /**
     * @test
     */
    public function it_can_update_an_store_comment()
    {
        $store          = factory('App\Store')->create();
        $userId         = factory('App\User')->create()->id;
        $createdComment = $this->commentStub($userId, 1);
        $data           = ['body' => 'Replacement for the old content of the comment.'];

        $comment  = $store->comments()->save($createdComment);
        $response = $this->call('PUT', "/store/comment/$comment->id", $data);

        $this->assertEquals(200, $response->status());
        $this->seeInDatabase('comments', $data);
        $this->assertInstanceOf('App\Comment', $response->original['comment']);
    }

}
