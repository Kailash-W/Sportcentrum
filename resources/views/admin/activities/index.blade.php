@extends('layouts.admin')

@section('title', 'Activiteitenbeheer')

@section('admin')
    <h1>Activiteitenbeheer</h1>
    <a class="btn s" href="{{ route('admin.activities.create') }}">+ Activiteit toevoegen</a>

    @if ($activities->isEmpty())
        <p class="empty" style="margin-top:10px">Er zijn nog geen activiteiten.</p>
    @else
        <div class="tw" style="margin-top:10px">
            <table>
                <tr><th>Naam</th><th>Beschrijving</th><th>Datum</th><th>Acties</th></tr>
                @foreach ($activities as $activity)
                    <tr>
                        <td><b>{{ $activity->name }}</b></td>
                        <td>{{ \Illuminate\Support\Str::limit($activity->description, 80) }}</td>
                        <td>{{ $activity->date?->format('d-m-Y') }}</td>
                        <td>
                            <a class="btn s o" href="{{ route('admin.activities.edit', $activity) }}">Wijzig</a>
                            <form class="inline" method="POST" action="{{ route('admin.activities.destroy', $activity) }}" onsubmit="return confirm('Deze activiteit verwijderen?')">
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
