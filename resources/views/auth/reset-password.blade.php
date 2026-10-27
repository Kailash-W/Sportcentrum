@extends('layouts.app')

@section('title', 'Nieuw wachtwoord')

@section('content')
    <div class="narrow">
        <h1>Nieuw wachtwoord</h1>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="f">
                <label for="email">E-mailadres</label>
                <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required>
            </div>
            <div class="f">
                <label for="password">Nieuw wachtwoord</label>
                <input id="password" type="password" name="password" required minlength="8" autocomplete="new-password">
            </div>
            <div class="f">
                <label for="password_confirmation">Herhaal wachtwoord</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
            </div>
            <button type="submit" class="btn full">Wachtwoord opslaan</button>
        </form>
    </div>
@endsection
