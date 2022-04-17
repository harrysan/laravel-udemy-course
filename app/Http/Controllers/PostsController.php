<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\Facades\DB;

// Controller Method	Policy Method
// index    => viewAny
// show     => view
// create	=> create
// store	=> create
// edit     => update
// update   => update
// destroy  => delete

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // DB::enableQueryLog();

        // $posts = BlogPost::all();
        // $posts = BlogPost::with('comments')->get();

        // foreach($posts as $post) {
        //     foreach($post->comments as $comment) {
        //         echo $comment->content;
        //     }
        // }

        // dd(DB::getQueryLog());

        // return view('posts.index', ['posts' => BlogPost::all()]);
        // comments_count
        return view('posts.index', 
                    ['posts' => BlogPost::withCount('comments')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // $this->authorize('posts.create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        //
        $validated = $request->validated();
        // $post = new BlogPost();
        // $post->title = $validated['title'];
        // $post->content = $validated['content'];
        $post = BlogPost::create($validated);
        //$post->save();

        $request->session()->flash('status','The blogpost was created');

        return redirect()->route('posts.show', ['post'=>$post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        //dd($id);
        //return view('posts.show', ['post' => BlogPost::findOrFail($id)]); 
        return view('posts.show', ['post' => BlogPost::with('comments')->findOrFail($id)]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = BlogPost::findOrFail($id);

        // if(Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this blog post!");
        // }
        // $this->authorize('update-post', ['post' => $post]);
        //dd($post->user_id);

        // $this->authorize('update', $post);
        $this->authorize($post);

        return view('posts.edit',['post' => BlogPost::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        //
        $post = BlogPost::findOrFail($id);

        // if(Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this blog post!");
        // }
        // $this->authorize('update-post', ['post' => $post]);
        // $this->authorize('posts.update', ['post' => $post]);
        $this->authorize('update', $post);

        $validated = $request->validated();
        $post->fill($validated);
        $post->save();

        $request->session()->flash('status','The blogpost was updated!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //
        // dd($id);
        $post = BlogPost::findOrFail($id);

        // if(Gate::denies('delete-post', $post)) {
        //     abort(403, "You can't delete this blog post!");
        // }
        // $this->authorize('update-post', ['post' => $post]);
        // $this->authorize('posts.delete', ['post' => $post]);
        $this->authorize('delete', $post);

        $post->delete();

        session()->flash('status','BlogPost was deleted');
        return redirect()->route('posts.index');
    }
}
