@extends('layouts.app')

@section('title', 'Registreren')

@section('content')
    <div class="narrow">
        <h1>Account aanmaken</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="f">
                <label for="name">Naam</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            </div>
            <div class="f">
                <label for="address">Adres</label>
                <input id="address" type="text" name="address" value="{{ old('address') }}" required autocomplete="street-address">
            </div>
            <div class="f">
                <label for="phone">Telefoonnummer</label>
                <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required autocomplete="tel">
            </div>
            <div class="f">
                <label for="email">E-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
            </div>
            <div class="f">
                <label for="password">Wachtwoord</label>
                <input id="password" type="password" name="password" placeholder="••••••••" required minlength="8" autocomplete="new-password">
                <small>Minimaal 8 tekens.</small>
            </div>
            <button type="submit" class="btn full">Account aanmaken</button>
        </form>
        <p style="text-align:center">Al een account? <a href="{{ route('login') }}">Inloggen</a></p>
    </div>
@endsection
