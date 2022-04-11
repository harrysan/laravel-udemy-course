@extends('layouts.app')

@section('title', 'Create the post')
    
@section('content')
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
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
            <input type="submit" class="mt-3 btn btn-primary btn-block" value="Create">
        </div>
    </form>
@endsection