@extends('layouts.trainer')

@section('title', 'Deelnemers')

@section('trainer')
    <h1>Deelnemerslijst</h1>

    @if ($lessons->isEmpty())
        <p class="empty">U heeft geen komende lessen.</p>
    @else
        <div class="grid g2">
            @foreach ($lessons as $lesson)
                <div class="card blue">
                    <h3>{{ $lesson->name }} – {{ $lesson->date->format('d-m') }} · {{ $lesson->start_label }}</h3>
                    <small>{{ $lesson->location->name }} · {{ $lesson->participants->count() }}/{{ $lesson->max_amount }}</small>
                    <p>
                        @forelse ($lesson->participants as $participant)
                            {{ $loop->iteration }}. {{ $participant->name }}<br>
                        @empty
                            Nog geen inschrijvingen.
                        @endforelse
                    </p>
                    <a class="btn s" href="{{ route('trainer.lessons.participants', $lesson) }}">Deelnemers</a>
                </div>
            @endforeach
        </div>
    @endif
@endsection
