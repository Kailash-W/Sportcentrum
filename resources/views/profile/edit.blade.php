@extends('layouts.app')

@section('title', 'Mijn profiel')

@section('content')
    <div class="profilefix">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="grid g2">

                <div>
                    <h1>Mijn profiel</h1>
                    <div class="f">
                        <label for="name">Naam</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="f">
                        <label for="email">E-mail</label>
                        <input id="email" type="email" value="{{ $user->email }}" disabled>
                    </div>
                    <div class="f">
                        <label for="phone">Telefoon wijzigen</label>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone', $profile->phone) }}">
                    </div>
                    @if ($user->role === 'participant')
                        <div class="f">
                            <label for="address">Adres wijzigen</label>
                            <input id="address" type="text" name="address" value="{{ old('address', $profile->address) }}">
                        </div>
                    @endif
                    <div class="f">
                        <label for="password">Wachtwoord wijzigen</label>
                        <input id="password" type="password" name="password" placeholder="••••••••" minlength="8"
                            autocomplete="new-password">
                        <small>Laat leeg om uw wachtwoord te behouden.</small>
                    </div>
                    <button type="submit" class="btn">Opslaan</button>
                </div>
            </div>
        </form>
    </div>
@endsection