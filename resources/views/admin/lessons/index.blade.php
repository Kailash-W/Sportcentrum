@extends('layouts.admin')

@section('title', 'Lesbeheer')

@section('admin')
    <h1>Lesbeheer</h1>
    <a class="btn s" href="{{ route('admin.lessons.create') }}">+ Les aanmaken</a>

    @if ($lessons->isEmpty())
        <p class="empty" style="margin-top:10px">Er zijn nog geen lessen.</p>
    @else
        <div class="tw" style="margin-top:10px">
            <table>
                <tr><th>Les</th><th>Datum</th><th>Tijd</th><th>Trainer</th><th>Zaal</th><th>Inschr.</th><th>Acties</th></tr>
                @foreach ($lessons as $lesson)
                    <tr>
                        <td><b>{{ $lesson->name }}</b></td>
                        <td>{{ $lesson->date->format('d-m-Y') }}</td>
                        <td>{{ $lesson->start_label }} – {{ $lesson->end_label }}</td>
                        <td>{{ $lesson->trainer->name }}</td>
                        <td>{{ $lesson->location->name }}</td>
                        <td>{{ $lesson->participants_count }}/{{ $lesson->max_amount }}</td>
                        <td>
                            <a class="btn s o" href="{{ route('admin.lessons.edit', $lesson) }}">Wijzig</a>
                            <form class="inline" method="POST" action="{{ route('admin.lessons.destroy', $lesson) }}" onsubmit="return confirm('Deze les verwijderen? Inschrijvingen verdwijnen ook.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn s r">Verwijder</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif
@endsection
