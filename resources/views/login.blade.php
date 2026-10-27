@extends('layouts.app')

@section('title', 'Inloggen - Sportcentrum De Linde')

@section('content')
    <div class="login-box">
        <h1>Inloggen</h1>
        <p class="hint">Leden, trainers en beheerders loggen hier in.</p>

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <label for="email">E-mailadres</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror

            <label for="password">Wachtwoord</label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror

            <label class="checkbox">
                <input type="checkbox" name="remember"> Onthoud mij
            </label>

            <button type="submit" class="btn btn-blue">Inloggen</button>
        </form>
    </div>
@endsection