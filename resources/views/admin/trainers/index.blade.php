@extends('layouts.admin')

@section('title', 'Trainerbeheer')

@section('admin')
    <h1>Trainerbeheer</h1>
    <a class="btn s" href="{{ route('admin.trainers.create') }}">+ Trainer toevoegen</a>

    @if ($trainers->isEmpty())
        <p class="empty" style="margin-top:10px">Er zijn nog geen trainers.</p>
    @else
        <div class="tw" style="margin-top:10px">
            <table>
                <tr><th>Naam</th><th>E-mail</th><th>Telefoon</th><th>Lessen</th><th>Acties</th></tr>
                @foreach ($trainers as $trainer)
                    <tr>
                        <td><b>{{ $trainer->name }}</b></td>
                        <td>{{ $trainer->user?->email }}</td>
                        <td>{{ $trainer->phone }}</td>
                        <td>{{ $trainer->lessons_count }}</td>
                        <td>
                            <a class="btn s o" href="{{ route('admin.trainers.edit', $trainer) }}">Wijzig</a>
                            <form class="inline" method="POST" action="{{ route('admin.trainers.destroy', $trainer) }}" onsubmit="return confirm('Deze trainer verwijderen?')">
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
