@extends('layouts.app')

@section('title', $post->title)
    
@section('content')
<div class="row">
    <div class="col-8">
        @if ($post->image)
            <div style="background-image: url('{{ $post->image->url($post->image->path) }}');
                        min-height: 500px; 
                        color:white; 
                        text-align:center; 
                        background-attachment:fixed;">
                <h1 style="padding-top: 100px;
                            text-shadow: 1px 2px #000">                  
        @else
            <h1>
        @endif
        {{-- <h1> --}}
            {{ $post->title }}
            
            {{-- @component('components.badge', ['type' => 'primary']) --}}
            @badge(['show' => now()->diffInMinutes($post->created_at) < 20])
                Brand new Post!
            @endbadge
            {{-- @endcomponent --}}
        @if ($post->image)
            </>
            </div>
        @else
            </h1>
        @endif
        
        <p>{{ $post->content }}</p>

        {{-- <img src="http://127.0.0.1:8000/storage/{{ $post->image->path }}" alt=""> --}}
        {{-- <img src="{{ Storage::url($post->image->path) }}" alt=""> --}}
        {{-- <img src="{{ $post->image->url($post->image->path) }}" alt=""> --}}

        {{-- <p>Added {{ $post->created_at->diffForHumans() }}</p> --}}
        @updated(['date' => $post->created_at, 'name' => $post->user->name])
        @endupdated

        @updated(['date' => $post->updated_at])
            Updated
        @endupdated

        @tags(['tags' => $post->tags])
        @endtags

        <p>Currently read by {{ $counter }} people</p>

        <h4 class="mt-3">Comments</h4>

        @include('comments._form')

        @forelse ($post->comments as $comment)
            <p>{{ $comment->content }} </p>
            
            {{-- <p class="text-muted">added {{ $comment->created_at->diffForHumans() }}</p> --}}
            @updated(['date' => $comment->created_at, 'name' => $comment->user->name])
            @endupdated

        @empty
            <p>No comments yet!</p>
        @endforelse
    </div>

    <div class="col-4">
        @include('posts._activity')
    </div>
</div>
@endsection