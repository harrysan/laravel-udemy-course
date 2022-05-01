<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Jobs\ThrottledMail;
use App\Mail\CommentPosted;
use App\Mail\CommentPostedMarkdown;
use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostCommentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function store(BlogPost $post, StoreComment $request)
    {
        // Comment::create()
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        // Using queue connection database
        // Mail::to($post->user)->send(
        //     new CommentPostedMarkdown($comment)
        // );

        //$when = now()->addMinutes(1);
        // Mail::to($post->user)->later(
        //     $when,
        //     new CommentPostedMarkdown($comment)
        // );

        // Mail::to($post->user)->queue(
        //     new CommentPostedMarkdown($comment)
        // );

        // using queue connection redis
        ThrottledMail::dispatch(new CommentPostedMarkdown($comment), $post->user)
                        ->onQueue('low');

        NotifyUsersPostWasCommented::dispatch($comment)
                                    ->onQueue('high');

        // $request->session()->flash('status','Comment was created');

        return redirect()->back()
                        ->with('status', 'Comment was created');
    }
}
