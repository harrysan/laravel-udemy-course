<p>
    @foreach ($tags as $tag)
        <a href="{{ route('posts.tags.index', ['tag' => $tag->id]) }}" style="text-decoration: none" 
            class="badge badge-lg alert-success">{{ $tag->name }}</a>
    @endforeach
</p>