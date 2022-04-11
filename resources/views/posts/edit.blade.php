@extends('layouts.app')

@section('title', 'Update the post')
    
@section('content')
    <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="POST">
        @csrf
        @method('PUT')
        @include('posts.partial.form')
        {{-- @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        <div>
            <input class="btn btn-primary btn-block mt-3" type="submit" value="Update">
        </div>
    </form>
@endsection