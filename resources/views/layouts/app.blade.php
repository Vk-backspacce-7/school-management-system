<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Dashboard'))</title>

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @stack('styles')

    @auth
        @php
            $layoutRole = strtolower((string) (auth()->user()->role ?? ''));
        @endphp
        @if(in_array($layoutRole, ['principal', 'teacher'], true))
            <link rel="stylesheet" href="{{ asset('css/interaction-ui.css') }}">
        @endif
    @endauth
</head>
<body class="@yield('body_class')">
@include('partials.flash-notifications')

<div class="@yield('shell_class', 'app-shell')">
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container-fluid px-3 px-lg-4">
            <a class="navbar-brand" href="#" data-section="mainContent">@yield('nav_brand', 'Dashboard')</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    @yield('nav_links')

                    @auth
                        @php
                            $interactionRole = strtolower((string) (auth()->user()->role ?? ''));
                        @endphp
                        @if(in_array($interactionRole, ['principal', 'teacher'], true))
                            @include('partials.notification-bell')
                            @include('chat.index')
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
</div>

@stack('modals')

<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@auth
    @php
        $scriptRole = strtolower((string) (auth()->user()->role ?? ''));
    @endphp
    @if(in_array($scriptRole, ['principal', 'teacher'], true))
        <script defer src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
        <script defer src="{{ asset('js/interaction-ui.js') }}"></script>
        <script defer src="{{ asset('js/chat.js') }}"></script>
    @endif
@endauth

@stack('scripts')
</body>
</html>
