@extends('layouts.admin')

@section('title', 'Ledenbeheer')

@section('admin')
    <h1>Ledenbeheer</h1>
    <a class="btn s" href="{{ route('admin.participants.create') }}">+ Lid toevoegen</a>

    @if ($participants->isEmpty())
        <p class="empty" style="margin-top:10px">Er zijn nog geen leden.</p>
    @else
        <div class="tw" style="margin-top:10px">
            <table>
                <tr><th>Naam</th><th>E-mail</th><th>Telefoon</th><th>Adres</th><th>Lessen</th><th>Acties</th></tr>
                @foreach ($participants as $participant)
                    <tr>
                        <td><b>{{ $participant->name }}</b></td>
                        <td>{{ $participant->user?->email }}</td>
                        <td>{{ $participant->phone }}</td>
                        <td>{{ $participant->address }}</td>
                        <td>{{ $participant->lessons_count }}</td>
                        <td>
                            <a class="btn s o" href="{{ route('admin.participants.edit', $participant) }}">Wijzig</a>
                            <form class="inline" method="POST" action="{{ route('admin.participants.destroy', $participant) }}" onsubmit="return confirm('Dit lid verwijderen?')">
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
