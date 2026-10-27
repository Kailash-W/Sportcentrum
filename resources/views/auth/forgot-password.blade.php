@extends('layouts.app')

@section('title', 'Wachtwoord vergeten')

@section('content')
    <div class="narrow">
        <h1>Wachtwoord vergeten</h1>
        <p>Vul uw e-mailadres in. U ontvangt een link om een nieuw wachtwoord in te stellen.</p>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="f">
                <label for="email">E-mailadres</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <button type="submit" class="btn full">Link versturen</button>
        </form>
        <p style="text-align:center"><a href="{{ route('login') }}">Terug naar inloggen</a></p>
    </div>
@endsection
