<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Poppins" rel="stylesheet">
    <!-- Style -->
    <link href="{{ asset('libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    @livewireStyles
    @yield('styles')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/books') }}">Books</a>
                        </li>
                        @if (\App\Services\IsAdmin::check(Auth::user()))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/genres') }}">Genres</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/users') }}">Users</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/borrows') }}">Borrows</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/notifications') }}">Notification</a>
                            </li>
                        @elseif (Auth::check())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/borrows/mine') }}">Borrows</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/notifications/mine') }}">
                                    <div class="position-relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                                            <path
                                                d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                                        </svg>
                                        @if (\App\Services\NotificationCount::get() != 0)
                                            <span
                                                class="position-absolute bottom-0 start-100 translate-middle bg-danger border border-light rounded-circle">
                                                <span
                                                    class="badge">{{ \App\Services\NotificationCount::get() }}</span>
                                                <span class="visually-hidden">New alerts</span>
                                            </span>
                                        @endif
                                    </div>
                                </a>
                            </li>
                        @endif
                    </ul>

                    @include('partials.nav-auth')
                </div>
            </div>
        </nav>

        <main class="container py-4">
            @yield('content')
        </main>
    </div>
    @livewireScripts
    @yield('scripts')
</body>

</html>
