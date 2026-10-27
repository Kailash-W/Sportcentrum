@extends('layouts.admin')

@section('title', $lesson ? 'Les wijzigen' : 'Les aanmaken')

@section('admin')
    <h1>{{ $lesson ? 'Les wijzigen' : 'Les aanmaken' }}</h1>

    @if ($trainers->isEmpty())
        <p class="alert">Er is nog geen trainer. <a href="{{ route('admin.trainers.create') }}">Voeg eerst een trainer toe.</a></p>
    @endif
    @if ($locations->isEmpty())
        <p class="alert">Er is nog geen locatie (zaal) in de tabel <code>location</code>. Voeg die eerst toe via phpMyAdmin of de seeder.</p>
    @endif

    <form method="POST" action="{{ $lesson ? route('admin.lessons.update', $lesson) : route('admin.lessons.store') }}" style="max-width:560px">
        @csrf
        @if ($lesson) @method('PUT') @endif

        <div class="f">
            <label for="name">Naam les</label>
            <input id="name" type="text" name="name" value="{{ old('name', $lesson->name ?? '') }}" required>
        </div>
        <div class="f">
            <label for="description">Beschrijving</label>
            <textarea id="description" name="description" rows="3">{{ old('description', $lesson->description ?? '') }}</textarea>
        </div>
        <div class="row2">
            <div class="f">
                <label for="date">Datum</label>
                <input id="date" type="date" name="date" value="{{ old('date', $lesson ? $lesson->date->format('Y-m-d') : '') }}" required>
            </div>
            <div class="f">
                <label for="max_amount">Max. deelnemers</label>
                <input id="max_amount" type="number" name="max_amount" min="1" value="{{ old('max_amount', $lesson->max_amount ?? 10) }}" required>
            </div>
        </div>
        <div class="row2">
            <div class="f">
                <label for="start_time">Starttijd</label>
                <input id="start_time" type="time" name="start_time" value="{{ old('start_time', $lesson ? $lesson->start_label : '') }}" required>
            </div>
            <div class="f">
                <label for="end_time">Eindtijd</label>
                <input id="end_time" type="time" name="end_time" value="{{ old('end_time', $lesson ? $lesson->end_label : '') }}" required>
            </div>
        </div>
        <div class="row2">
            <div class="f">
                <label for="trainer_id">Trainer</label>
                <select id="trainer_id" name="trainer_id" required>
                    <option value="">Kies een trainer</option>
                    @foreach ($trainers as $trainer)
                        <option value="{{ $trainer->id }}" @selected(old('trainer_id', $lesson->trainer_id ?? null) == $trainer->id)>{{ $trainer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="f">
                <label for="location_id">Zaal</label>
                <select id="location_id" name="location_id" required>
                    <option value="">Kies een zaal</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" @selected(old('location_id', $lesson->location_id ?? null) == $location->id)>{{ $location->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="btn">Opslaan</button>
        <a class="btn o" href="{{ route('admin.lessons.index') }}">Annuleren</a>
    </form>
@endsection
