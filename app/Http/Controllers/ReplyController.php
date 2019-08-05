<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    
    public function store(Request $request)
    {
        $comment = Comment::find($request->comment_id);
        $reply   = $comment->replies()
                        ->save(new Reply($request->except('comment_id')));
        return response()->json($reply, 201);
    }

    public function update(Request $request, $id)
    {
        $reply = Reply::find($id);
        $reply->body = $request->body;
        $reply->save();
        return $reply;
    }
}
