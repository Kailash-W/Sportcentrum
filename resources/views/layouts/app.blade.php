<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@hasSection('title')@yield('title') – @endif Sportcentrum De Linde</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;600&family=Barlow+Condensed:ital,wght@1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/linde.css') }}">
</head>
<body>
@php
    // [label, routenaam, patroon voor de actieve stand] per rol, zoals in "Menu per rol" in de wireframe
    $role = auth()->user()?->role;
    $links = match ($role) {
        'admin' => [
            ['Dashboard', 'admin.dashboard', 'admin.dashboard'],
            ['Leden', 'admin.participants.index', 'admin.participants.*'],
            ['Trainers', 'admin.trainers.index', 'admin.trainers.*'],
            ['Medewerkers', 'admin.employees.index', 'admin.employees.*'],
            ['Lessen', 'admin.lessons.index', 'admin.lessons.*'],
            ['Activiteiten', 'admin.activities.index', 'admin.activities.*'],
        ],
        'trainer' => [
            ['Dashboard', 'trainer.dashboard', 'trainer.dashboard'],
            ['Mijn Lessen', 'trainer.lessons.index', 'trainer.lessons.*'],
            ['Deelnemers', 'trainer.participants', 'trainer.participants'],
            ['Profiel', 'profile.edit', 'profile.*'],
        ],
        'participant' => [
            ['Dashboard', 'participant.dashboard', 'participant.dashboard'],
            ['Lessen', 'participant.lessons.index', 'participant.lessons.*'],
            ['Activiteiten', 'participant.activities', 'participant.activities'],
            ['Mijn Profiel', 'profile.edit', 'profile.*'],
        ],
        default => [
            ['Home', 'home', 'home'],
            ['Inloggen', 'login', 'login'],
            ['Registreren', 'register', 'register'],
        ],
    };
@endphp

<header class="bar">
    <a class="brand" href="{{ route('home') }}">Sportcentrum De Linde</a>
    <button class="ham" type="button" id="ham" aria-label="Menu" aria-expanded="false">☰</button>
    <nav class="links" id="links">
        @foreach ($links as [$label, $route, $pattern])
            <a href="{{ route($route) }}" class="{{ request()->routeIs($pattern) ? 'act' : '' }}">{{ $label }}</a>
        @endforeach
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="navbtn">Uitloggen</button>
            </form>
        @endauth
    </nav>
</header>

<main>
    @include('partials.flash')
    @yield('content')
</main>

<footer class="foot">
    <b><a href="{{ route('home') }}#contact" style="text-decoration:none">Contact</a></b>
    <a href="{{ route('privacy') }}">Privacybeleid</a>
    <a href="{{ route('terms') }}">Algemene voorwaarden</a>
    <span>info@delinde.nl</span>
    <span>012-3456789</span>
    <span>Lindelaan 1, Breda</span>
</footer>

<script>
    // Hamburgermenu op mobiel
    (function () {
        var ham = document.getElementById('ham'), links = document.getElementById('links');
        ham.addEventListener('click', function () {
            var open = links.classList.toggle('open');
            ham.textContent = open ? '✕' : '☰';
            ham.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    })();
</script>
</body>
</html>
