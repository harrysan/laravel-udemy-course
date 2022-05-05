<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted as EventsCommentPosted;
use App\Http\Requests\StoreComment;
use App\Models\BlogPost;
use App\Http\Resources\Comment as CommentResource;

class PostCommentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function index(BlogPost $post)
    {
        return CommentResource::collection($post->comments()->with('user')->get());
        // return $post->comments()->with('user')->get();
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

        // event
        event(new EventsCommentPosted($comment));

        // using queue connection redis -> move to listener
        // ThrottledMail::dispatch(new CommentPostedMarkdown($comment), $post->user)
        //                 ->onQueue('low');

        // NotifyUsersPostWasCommented::dispatch($comment)
        //                             ->onQueue('high');

        // $request->session()->flash('status','Comment was created');

        return redirect()->back()
                        ->with('status', 'Comment was created');
    }
}
