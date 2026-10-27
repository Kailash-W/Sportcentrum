@extends('layouts.admin')

@section('title', $participant ? 'Lid wijzigen' : 'Lid toevoegen')

@section('admin')
    <h1>{{ $participant ? 'Lid wijzigen' : 'Lid toevoegen' }}</h1>

    <form method="POST" action="{{ $participant ? route('admin.participants.update', $participant) : route('admin.participants.store') }}" style="max-width:520px">
        @csrf
        @if ($participant) @method('PUT') @endif

        <div class="f">
            <label for="name">Naam</label>
            <input id="name" type="text" name="name" value="{{ old('name', $participant->name ?? '') }}" required>
        </div>
        <div class="f">
            <label for="email">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email', $participant->user->email ?? '') }}" required>
        </div>
        <div class="row2">
            <div class="f">
                <label for="phone">Telefoon</label>
                <input id="phone" type="tel" name="phone" value="{{ old('phone', $participant->phone ?? '') }}">
            </div>
            <div class="f">
                <label for="address">Adres</label>
                <input id="address" type="text" name="address" value="{{ old('address', $participant->address ?? '') }}">
            </div>
        </div>
        <div class="f">
            <label for="password">Wachtwoord</label>
            <input id="password" type="password" name="password" minlength="8" {{ $participant ? '' : 'required' }}>
            @if ($participant) <small>Laat leeg om het wachtwoord te behouden.</small> @endif
        </div>

        <button type="submit" class="btn">Opslaan</button>
        <a class="btn o" href="{{ route('admin.participants.index') }}">Annuleren</a>
    </form>
@endsection
