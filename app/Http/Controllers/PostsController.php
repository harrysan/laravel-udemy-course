<?php

namespace App\Http\Controllers;

// use App\Contracts\CounterContract;
use App\Events\BlogPostPosted;
use App\Facades\CounterFacades;
use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\Image;
use App\Models\User;
// use App\Services\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

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
    // private $counter;

    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);

        // $this->middleware('locale');
        // $this->counter = $counter;
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
                    ['posts' => BlogPost::latestWithRelations()->get()]);
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
        $validated['user_id'] = $request->user()->id;

        // $post = new BlogPost();
        // $post->title = $validated['title'];
        // $post->content = $validated['content'];
        $blogPost = BlogPost::create($validated);
        //$post->save();

        // $hasFile = $request->hasFile('thumbnail');
        // dump($hasFile);

        if($request->hasFile('thumbnail'))
        {
            // $name1 = $file->storeAs('thumbnails', $post->id . '.' . $file->guessExtension());
            // $name2 = Storage::disk('local')->putFileAs('thumbnails', $file, $post->id . '.' . $file->guessExtension());

            // dump(Storage::url($name1));
            // dump(Storage::disk('local')->url($name2));

            $path = $request->file('thumbnail')->store('thumbnails');
            $blogPost->image()->save(
                Image::make(['path' => $path])
            );
        }
        //die;

        event(new BlogPostPosted($blogPost));

        $request->session()->flash('status','The blogpost was created');

        return redirect()->route('posts.show', ['post'=>$blogPost->id]);
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

        // with local scopes
        // return view('posts.show', ['post' => BlogPost::with(['comments' => function ($query)
        // {
        //     return $query->latest();
        // }])->findOrFail($id)]);

        // Cache
        // $blogPost = Cache::remember("blog-post-{$id}", 60, function () use ($id) {
        //     return BlogPost::with('comments')->findOrFail($id);
        // });

        // Redis using tags
        $blogPost = Cache::tags(['blog-post'])->remember("blog-post-{$id}", 60, function () use ($id) {
            return BlogPost::with('comments', 'tags', 'user', 'comments.user')
                                // ->with('tags')
                                // ->with('user')
                                // ->with('comments.user')
                                ->findOrFail($id);
        });

        // $counter = resolve(Counter::class);

        return view('posts.show', ['post' => $blogPost, 
                    'counter' => CounterFacades::increment("blog-post-{$id}", ['blog-post'])]); 
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

        if($request->hasFile('thumbnail'))
        {
            $path = $request->file('thumbnail')->store('thumbnails');

            if($post->image)
            {
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            }
            else {
                $post->image()->save(
                    // $image = new Image();
                    // $image->imageable_id = $post->id;
                    Image::make(['path' => $path])
                );
            }
        }

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
