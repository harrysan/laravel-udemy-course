@extends('layouts.app')

@section('title', $post->title)
    
@section('content')
<div class="row">
    <div class="col-8">
        <h1>
            {{ $post->title }}
            
            {{-- @component('components.badge', ['type' => 'primary']) --}}
            @badge(['show' => now()->diffInMinutes($post->created_at) < 20])
                Brand new Post!
            @endbadge
            {{-- @endcomponent --}}
        </h1>
        <p>{{ $post->content }}</p>

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