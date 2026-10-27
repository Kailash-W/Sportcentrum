@extends('layouts.trainer')

@section('title', $lesson->name)

@section('trainer')
    <h1>Details – {{ $lesson->name }}</h1>

    <div class="card blue">
        <p><b>Datum:</b> {{ $lesson->date->format('d-m-Y') }}</p>
        <p><b>Tijd:</b> {{ $lesson->start_label }} – {{ $lesson->end_label }}</p>
        <p><b>Zaal:</b> {{ $lesson->location->name }}</p>
        <p><b>Trainer:</b> {{ $lesson->trainer->name }}</p>
        <p><b>Inschrijvingen:</b> {{ $lesson->participants_count }} van max. {{ $lesson->max_amount }}</p>
        @if ($lesson->description)
            <p><b>Beschrijving:</b><br>{{ $lesson->description }}</p>
        @endif
    </div>

    <p style="margin-top:14px">
        <a class="btn" href="{{ route('trainer.lessons.participants', $lesson) }}">Deelnemers</a>
        <a class="btn o" href="{{ route('trainer.lessons.index') }}">Terug naar mijn lessen</a>
    </p>
@endsection
