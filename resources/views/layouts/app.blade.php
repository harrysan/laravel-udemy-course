<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <title>Laravel 8</title>
</head>
<body>
    <div class="justify-content-between d-flex flex-column flex-md-row align-items-center p-3 px-md-4 bg-white border-bottom shadow-sm mb-3">
        <h5 class="my-0 mr-md-auto font-weight-normal">Laravel App</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="text-decoration-none p-2 text-dark" href="{{ route('home.index') }}">Home</a>
            <a class="text-decoration-none p-2 text-dark" href="{{ route('home.contact') }}">Contact</a>
            <a class="text-decoration-none p-2 text-dark" href="{{ route('posts.index') }}">Blog Posts</a>
            <a class="text-decoration-none p-2 text-dark" href="{{  route('posts.create') }}">Add</a>

            @guest
                @if (Route::has('register'))
                    <a class="text-decoration-none p-2 text-dark" href="{{ route('register') }}">Register</a>
                @endif
                    <a class="text-decoration-none p-2 text-dark" href="{{ route('login') }}">Login</a>
            @else
                    <a class="text-decoration-none p-2 text-dark" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    >Logout ({{ Auth::user()->name }})</a>

                    <form method="POST" id="logout-form" action="{{ route('logout') }}" style="display: none;">
                        @csrf
                    </form>
            @endguest
        </nav>
    </div>
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @yield('content')
    </div>
</body>
</html>