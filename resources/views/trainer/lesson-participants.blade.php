@extends('layouts.trainer')

@section('title', 'Deelnemers')

@section('trainer')
    <h1>Deelnemers – {{ $lesson->name }} {{ $lesson->date->format('d-m') }}</h1>
    <p>{{ $lesson->location->name }} · {{ $lesson->start_label }} – {{ $lesson->end_label }} · {{ $lesson->participants_count }}/{{ $lesson->max_amount }} ingeschreven</p>

    @if ($participants->isEmpty())
        <p class="empty">Er zijn nog geen inschrijvingen voor deze les.</p>
    @else
        <div class="tw">
            <table>
                <tr><th>#</th><th>Naam</th><th>E-mail</th><th>Telefoon</th></tr>
                @foreach ($participants as $participant)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><b>{{ $participant->name }}</b></td>
                        <td>{{ $participant->user?->email }}</td>
                        <td>{{ $participant->phone }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

    <p style="margin-top:14px">
        <a class="btn o" href="{{ route('trainer.lessons.show', $lesson) }}">Details</a>
        <a class="btn o" href="{{ route('trainer.lessons.index') }}">Terug naar mijn lessen</a>
    </p>
@endsection
