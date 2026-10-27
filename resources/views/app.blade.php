<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sportcentrum De Linde')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<header class="site-header">
    <div class="container header-inner">
        <a href="{{ route('home') }}" class="site-name">Sportcentrum De Linde</a>

        <nav>
            @auth
                <span class="welkom">Hallo, {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline-form">
                    @csrf
                    <button type="submit" class="btn btn-light">Uitloggen</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-light">Inloggen</a>
            @endauth
        </nav>
    </div>
</header>

<main class="site-main">
    <div class="container">
        @yield('content')
    </div>
</main>

<footer class="site-footer">
    <div class="container footer-inner">
        <div>
            <h3>Sportcentrum De Linde</h3>
            <p>Samen sporten, samen sterker.</p>
        </div>
        <div>
            <h3>Locatie</h3>
            <p>Lindelaan 12<br>4811 AB Breda</p>
        </div>
        <div>
            <h3>Contact</h3>
            <p>Telefoon: 076 - 123 45 67<br>E-mail: info@sportcentrumdelinde.nl</p>
        </div>
    </div>
    <div class="footer-bottom">&copy; {{ date('Y') }} Sportcentrum De Linde</div>
</footer>

</body>
</html>