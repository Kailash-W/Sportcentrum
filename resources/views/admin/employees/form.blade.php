@extends('layouts.admin')

@section('title', $employee ? 'Medewerker wijzigen' : 'Medewerker toevoegen')

@section('admin')
    <h1>{{ $employee ? 'Medewerker wijzigen' : 'Medewerker toevoegen' }}</h1>

    @php
        $linked = old('lessons', $employee ? $employee->lessons->pluck('id')->all() : []);
    @endphp

    <form method="POST" action="{{ $employee ? route('admin.employees.update', $employee) : route('admin.employees.store') }}" style="max-width:520px">
        @csrf
        @if ($employee) @method('PUT') @endif

        <div class="f">
            <label for="name">Naam</label>
            <input id="name" type="text" name="name" value="{{ old('name', $employee->name ?? '') }}" required>
        </div>
        <div class="f">
            <label for="position">Functie</label>
            <input id="position" type="text" name="position" value="{{ old('position', $employee->position ?? '') }}" placeholder="Bijv. Receptie" required>
        </div>

        <div class="f checks">
            <label>Koppelen aan lessen</label>
            @forelse ($lessons as $lesson)
                <label>
                    <input type="checkbox" name="lessons[]" value="{{ $lesson->id }}" @checked(in_array($lesson->id, $linked))>
                    {{ $lesson->name }} · {{ $lesson->date->format('d-m') }} {{ $lesson->start_label }} · {{ $lesson->trainer->name }}
                </label>
            @empty
                <small>Er zijn geen komende lessen om aan te koppelen.</small>
            @endforelse
        </div>

        <button type="submit" class="btn">Opslaan</button>
        <a class="btn o" href="{{ route('admin.employees.index') }}">Annuleren</a>
    </form>
@endsection
