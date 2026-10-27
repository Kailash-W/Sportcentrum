@extends('layouts.admin')

@section('title', $trainer ? 'Trainer wijzigen' : 'Trainer toevoegen')

@section('admin')
    <h1>{{ $trainer ? 'Trainer wijzigen' : 'Trainer toevoegen' }}</h1>

    <form method="POST" action="{{ $trainer ? route('admin.trainers.update', $trainer) : route('admin.trainers.store') }}" style="max-width:520px">
        @csrf
        @if ($trainer) @method('PUT') @endif

        <div class="f">
            <label for="name">Naam</label>
            <input id="name" type="text" name="name" value="{{ old('name', $trainer->name ?? '') }}" required>
        </div>
        <div class="f">
            <label for="email">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email', $trainer->user->email ?? '') }}" required>
        </div>
        <div class="f">
            <label for="phone">Telefoon</label>
            <input id="phone" type="tel" name="phone" value="{{ old('phone', $trainer->phone ?? '') }}">
        </div>
        <div class="f">
            <label for="password">Wachtwoord</label>
            <input id="password" type="password" name="password" minlength="8" {{ $trainer ? '' : 'required' }}>
            @if ($trainer) <small>Laat leeg om het wachtwoord te behouden.</small> @endif
        </div>

        <button type="submit" class="btn">Opslaan</button>
        <a class="btn o" href="{{ route('admin.trainers.index') }}">Annuleren</a>
    </form>
@endsection
