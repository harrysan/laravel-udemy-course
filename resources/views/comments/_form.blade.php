<div class="mb-2 mt-2">
    @auth
        <form action="{{ route('posts.comments.store', ['post' => $post->id]) }}" method="POST">
            @csrf
            <div class="form-group">
                <textarea type="text" class="form-control" id="content" name="content">

                </textarea>
                {{-- @error('content')
                    <div>{{ $message }}</div>
            @enderror --}}
            </div>
            
            <div>
                <button type="submit" class="mt-3 btn btn-primary btn-block">
                    Add Comment
                </button>
            </div>
        </form>
        @errors @enderrors
    @else
        <a href="{{ route('login') }}">Sign-in</a>to post comments!
    @endauth
</div>
<hr/>
