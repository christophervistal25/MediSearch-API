<?php

namespace App\Http\Controllers;
use App\Store;
use App\Comment;
use Illuminate\Http\Request;

class StoreCommentController extends Controller
{

    public function show($storeId)
    {
        $store = Store::with(['comments.user:id,fullname', 'comments.replies.user:id,fullname'])
                       ->find($storeId);
        return $store->comments;
    }

    public function store(Request $request)
    {
        $store   = Store::find($request->store_id);
        $comment = new Comment([
            'user_id' => $request->user_id,
            'body'    => $request->body
        ]);

        $insertedComment = $store->comments()->save($comment);

        return response()->json($insertedComment, 201);
    }

    public function update(Request $request, $commentId)
    {
        $comment = Comment::find($commentId);
        $comment->body = $request->body;
        $comment->save();

        return response()->json(['comment' => $comment]);
    }
}
