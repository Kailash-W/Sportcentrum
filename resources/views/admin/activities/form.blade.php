@extends('layouts.admin')

@section('title', $activity ? 'Activiteit wijzigen' : 'Activiteit toevoegen')

@section('admin')
    <h1>{{ $activity ? 'Activiteit wijzigen' : 'Activiteit toevoegen' }}</h1>

    <form method="POST" action="{{ $activity ? route('admin.activities.update', $activity) : route('admin.activities.store') }}" style="max-width:520px">
        @csrf
        @if ($activity) @method('PUT') @endif

        <div class="f">
            <label for="name">Naam</label>
            <input id="name" type="text" name="name" value="{{ old('name', $activity->name ?? '') }}" required>
        </div>
        <div class="f">
            <label for="description">Beschrijving</label>
            <textarea id="description" name="description" rows="4">{{ old('description', $activity->description ?? '') }}</textarea>
        </div>
        <div class="f">
            <label for="date">Datum</label>
            <input id="date" type="date" name="date" value="{{ old('date', $activity && $activity->date ? $activity->date->format('Y-m-d') : '') }}">
        </div>

        <button type="submit" class="btn">Opslaan</button>
        <a class="btn o" href="{{ route('admin.activities.index') }}">Annuleren</a>
    </form>
@endsection
