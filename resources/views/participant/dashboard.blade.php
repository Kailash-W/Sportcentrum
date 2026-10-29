@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Hallo, {{ $user->name }}</h1>

        <div class="card blue">
            <h3>Komende lessen</h3>
            @forelse ($upcoming as $lesson)
                <div class="okb" style="margin:8px 0">{{ $lesson->name }} · {{ $lesson->date->format('d-m') }} · {{ $lesson->start_label }}</div>
            @empty
                <p>U bent nog voor geen enkele les ingeschreven.</p>
            @endforelse
        </div>

        <div class="card">
            <h3>Mijn lessen</h3>
            <p>Overzicht van al mijn ingeschreven lessen</p>
            <p><a class="btn s" href="{{ route('participant.lessons.mine') }}">Lessen bekijken</a></p>
        </div>

        <div class="card">
            <h3>Activiteiten</h3>
            @if ($activities->isNotEmpty())
                <p>{{ $activities->pluck('name')->join(' · ') }}</p>
            @else
                <div class="photo" style="min-height:60px">📷</div>
            @endif
            <p><a class="btn s o" href="{{ route('participant.activities') }}">Alle activiteiten</a></p>
        </div>
    </div>

    <p style="margin-top:18px"><a class="btn" href="{{ route('participant.lessons.index') }}">Inschrijven voor een les</a></p>
@endsection
