@extends('layouts.app')

@section('title', 'Inloggen')

@section('content')
    <div class="narrow">
        <h1>Inloggen</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="f">
                <label for="email">E-mailadres</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>
            <div class="f">
                <label for="password">Wachtwoord</label>
                <input id="password" type="password" name="password" placeholder="••••••••" required autocomplete="current-password">
            </div>
            <div class="f checks">
                <label><input type="checkbox" name="remember" value="1"> Onthoud mij</label>
            </div>
            <button type="submit" class="btn full">Inloggen</button>
        </form>
        <p style="text-align:center"><a href="{{ route('password.request') }}">Wachtwoord vergeten?</a></p>
        <hr>
        <p style="text-align:center">Nog geen account?</p>
        <a class="btn o full" href="{{ route('register') }}">Registreren</a>
    </div>
@endsection
