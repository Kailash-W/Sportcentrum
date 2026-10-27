@extends('layouts.trainer')

@section('title', 'Dashboard')

@section('trainer')
    <h1>Mijn lessen</h1>
    @include('partials.trainer-lessons-table', ['lessons' => $lessons])

    @if ($next)
        <div class="grid g2" style="margin-top:14px">
            <div class="card blue">
                <h3>Details – {{ $next->name }} {{ $next->date->format('d-m') }}</h3>
                {{ $next->location->name }} · {{ $next->start_label }} – {{ $next->end_label }}<br>
                Max. {{ $next->max_amount }} deelnemers
                <p><a class="btn s o" href="{{ route('trainer.lessons.show', $next) }}">Details</a></p>
            </div>
            <div class="card blue">
                <h3>Deelnemers – {{ $next->name }} {{ $next->date->format('d-m') }}</h3>
                @forelse ($nextParticipants as $participant)
                    {{ $loop->iteration }}. {{ $participant->name }}<br>
                @empty
                    Nog geen inschrijvingen.
                @endforelse
                <p><a class="btn s" href="{{ route('trainer.lessons.participants', $next) }}">Deelnemers</a></p>
            </div>
        </div>
    @endif
@endsection
