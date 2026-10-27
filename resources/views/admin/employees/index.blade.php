@extends('layouts.admin')

@section('title', 'Medewerkerbeheer')

@section('admin')
    <h1>Medewerkerbeheer</h1>
    <a class="btn s" href="{{ route('admin.employees.create') }}">+ Medewerker toevoegen</a>

    @if ($employees->isEmpty())
        <p class="empty" style="margin-top:10px">Er zijn nog geen medewerkers.</p>
    @else
        <div class="tw" style="margin-top:10px">
            <table>
                <tr><th>Naam</th><th>Functie</th><th>Gekoppelde lessen</th><th>Acties</th></tr>
                @foreach ($employees as $employee)
                    <tr>
                        <td><b>{{ $employee->name }}</b></td>
                        <td>{{ $employee->position }}</td>
                        <td>{{ $employee->lessons_count }}</td>
                        <td>
                            <a class="btn s o" href="{{ route('admin.employees.edit', $employee) }}">Wijzig / koppel</a>
                            <form class="inline" method="POST" action="{{ route('admin.employees.destroy', $employee) }}" onsubmit="return confirm('Deze medewerker verwijderen?')">
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
