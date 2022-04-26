@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-4">
            <img src="{{ $user->image ? $user->image->url($user->image->path) : '' }}" 
                class="img-thumbnail avatar" />
        </div>
        <div class="col-8">
            <h3>{{ $user->name }}</h3>

            @commentForm(['route' => route('users.comments.store', ['user' => $user->id])])
            @endcommentForm

            @commentList(['comments' => $user->commentsOn])
            @endcommentList
        </div>
    </div>
@endsection