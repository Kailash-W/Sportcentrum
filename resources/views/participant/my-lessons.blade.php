@extends('layouts.app')

@section('title', 'Mijn lessen')

@section('content')
    <h1>Mijn lessen</h1>

    @if ($lessons->isEmpty())
        <p class="empty">U bent nog voor geen enkele les ingeschreven.</p>
    @else
        <div class="tw">
            <table>
                <tr><th>Les</th><th>Datum</th><th>Tijd</th><th>Trainer</th><th>Locatie</th><th>Actie</th></tr>
                @foreach ($lessons as $lesson)
                    <tr>
                        <td><b>{{ $lesson->name }}</b></td>
                        <td>{{ $lesson->date->format('d-m-Y') }}</td>
                        <td>{{ $lesson->start_label }} – {{ $lesson->end_label }}</td>
                        <td>{{ $lesson->trainer->name }}</td>
                        <td>{{ $lesson->location->name }}</td>
                        <td>
                            @if ($lesson->date->gte(today()))
                                <form class="inline" method="POST" action="{{ route('participant.lessons.withdraw', $lesson) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn s r">Afmelden</button>
                                </form>
                            @else
                                <small>Geweest</small>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

    <p style="margin-top:14px"><a class="btn" href="{{ route('participant.lessons.index') }}">Inschrijven voor een les</a></p>
@endsection
