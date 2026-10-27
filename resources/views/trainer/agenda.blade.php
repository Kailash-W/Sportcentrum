@extends('layouts.trainer')

@section('title', 'Agenda')

@section('trainer')
    <h1>Agenda</h1>

    <div class="weeknav">
        <a class="btn s o" href="{{ route('trainer.agenda', ['week' => $week - 1]) }}">← Vorige week</a>
        <a class="btn s o" href="{{ route('trainer.agenda') }}">Deze week</a>
        <a class="btn s o" href="{{ route('trainer.agenda', ['week' => $week + 1]) }}">Volgende week →</a>
    </div>

    <div class="cal">
        @foreach ($days as $day)
            <div class="day {{ $day->isToday() ? 'today' : '' }}">
                <div class="h">{{ $day->copy()->locale('nl')->isoFormat('ddd D MMM') }}</div>
                <div>
                    @forelse ($lessons->get($day->toDateString(), collect()) as $lesson)
                        <div class="e">
                            <b>{{ $lesson->start_label }}</b> {{ $lesson->name }}<br>
                            <small>{{ $lesson->location->name }} · {{ $lesson->participants_count }}/{{ $lesson->max_amount }}</small><br>
                            <a href="{{ route('trainer.lessons.show', $lesson) }}"><small>Details</small></a>
                        </div>
                    @empty
                        <small style="color:#8a94a6">–</small>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
@endsection
