@extends('layouts.app')

@section('title', 'Create the post')
    
@section('content')
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('posts.partial.form')
        <div>
            <input type="submit" class="mt-3 btn btn-primary btn-block" value="Create">
        </div>
    </form>
@endsection