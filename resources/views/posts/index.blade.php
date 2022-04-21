@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-8">
    @forelse ($posts as $post)
        <p>
            <h3>
                @if ($post->trashed())
                    <del>
                @endif
                <a 
                class="{{ $post->trashed() ? 'text-muted' : '' }}" 
                style="text-decoration:none" href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                @if ($post->trashed())
                    </del>
                @endif
            </h3>

            {{-- <p class="text-muted">
                Added {{ $post->created_at->diffForHumans() }}
                by {{ $post->user->name }}
            </p> --}}

            @updated(['date' => $post->created_at, 'name' => $post->user->name])
            @endupdated

            @if($post->comments_count)
                <p>{{ $post->comments_count }} comments</p>
            @else
                <p>No comments yet!</p>
            @endif

            
            <div class="mb-3">
                @auth
                    @can('update', $post)
                        <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
                    @endcan
                @endauth

                {{-- @cannot('delete', $post)
                    <p>You can't delete this post</p>
                @endcannot --}}

                @auth
                    @if (!$post->trashed())
                        @can('delete', $post)
                            <form class="d-inline" action="{{ route('posts.destroy',['post' => $post->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Delete" class="btn btn-primary">
                            </form>
                        @endcan
                    @endif
                @endauth
                
            </div>
        </p>
    @empty
        <p>No blog posts yet!</p>
    @endforelse
    </div>
    <div class="col-4">
        <div class="container">
            <div class="row">
                {{-- <div class="card" style="width: 100%">
                    <div class="card-body">
                        <h5 class="card-title">Most Commented</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            What people are currently talking about
                        </h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($mostCommented as $post)
                            <li class="list-group-item">
                                <a style="text-decoration:none" href="{{ route('posts.show', ['post' => $post->id]) }}">
                                    {{ $post->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div> --}}

                @card(['title' => 'Most Commented'])
                    @slot('subtitle')
                        What people are currently talking about
                    @endslot
                    @slot('items')
                        @foreach ($mostCommented as $post)
                            <li class="list-group-item">
                                <a style="text-decoration:none" href="{{ route('posts.show', ['post' => $post->id]) }}">
                                    {{ $post->title }}
                                </a>
                            </li>
                        @endforeach
                    @endslot
                @endcard()
            </div>

            <div class="row mt-4">
                {{-- <div class="card" style="width: 100%">
                    <div class="card-body">
                        <h5 class="card-title">Most Active Users</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            Users with most posts written
                        </h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($mostActive as $user)
                            <li class="list-group-item">
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>
                </div> --}}

                @card(['title' => 'Most Active Users'])
                    @slot('subtitle')
                        Users with most posts written
                    @endslot

                    @slot('items', collect($mostActive)->pluck('name'))
                @endcard()
            </div>

            <div class="row mt-4">
                {{-- <div class="card" style="width: 100%">
                    <div class="card-body">
                        <h5 class="card-title">Most Active Users Last Month</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            Users with most posts written in the month
                        </h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($mostActiveLastMonth as $user)
                            <li class="list-group-item">
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>
                </div> --}}

                @card(['title' => 'Most Active Users Last Month'])
                    @slot('subtitle')
                    Users with most posts written in the month
                    @endslot

                    @slot('items', collect($mostActiveLastMonth)->pluck('name'))
                @endcard()
            </div>
        </div>
    </div>
</div>
@endsection('content')