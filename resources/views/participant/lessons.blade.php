@extends('layouts.app')

@section('title', 'Lessen')

@section('content')
    <h1>Lesoverzicht</h1>

    @if ($lessons->isEmpty())
        <p class="empty">Er zijn op dit moment geen lessen gepland.</p>
    @else
        <div class="tw">
            <table>
                <tr><th>Les</th><th>Datum</th><th>Tijd</th><th>Trainer</th><th>Plaatsen</th><th>Actie</th></tr>
                @foreach ($lessons as $lesson)
                    @php
                        $enrolled = in_array($lesson->id, $enrolledIds);
                        $left = $lesson->spotsLeft();
                    @endphp
                    <tr>
                        <td><b>{{ $lesson->name }}</b><br><small>{{ $lesson->location->name }}</small></td>
                        <td>{{ $lesson->date->format('d-m-Y') }}</td>
                        <td>{{ $lesson->start_label }} – {{ $lesson->end_label }}</td>
                        <td>{{ $lesson->trainer->name }}</td>
                        <td>{{ $left > 0 ? $left.' vrij' : 'Vol' }}</td>
                        <td>
                            @if ($enrolled)
                                <form class="inline" method="POST" action="{{ route('participant.lessons.withdraw', $lesson) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn s r">Afmelden</button>
                                </form>
                            @elseif ($left > 0)
                                <form class="inline" method="POST" action="{{ route('participant.lessons.enroll', $lesson) }}">
                                    @csrf
                                    <button type="submit" class="btn s">Inschrijven</button>
                                </form>
                            @else
                                <span class="btn s o disabled">Vol</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

    <p><small>U kunt zich niet inschrijven voor twee lessen die op hetzelfde tijdstip plaatsvinden.</small></p>
@endsection
