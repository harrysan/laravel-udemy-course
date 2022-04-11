@extends('layouts.app')

@section('title', 'Create the post')
    
@section('content')
    
    @forelse ($posts as $key => $post)
        @include('posts.partial.post')
        
        @empty
        <p>No blog posts yet!</p>
    @endforelse
    
    {{-- @foreach ($posts as $post)
        {{ $i++ }}
        <h1>{{ $post->title }}</h1>
        <h3>{{ $post->content }}</h3>
    @endforeach --}}
@endsection