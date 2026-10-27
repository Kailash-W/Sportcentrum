@extends('layouts.admin')

@section('title', 'Beheer')

@section('admin')
    <h1>Beheer</h1>

    <div class="grid g3">
        @foreach ($counts as $label => $count)
            <div class="card blue">
                <div class="stat">{{ $count }}</div>
                {{ $label }}
            </div>
        @endforeach
    </div>

    <h2 class="section">Eerstvolgende lessen</h2>
    <p><a class="btn s" href="{{ route('admin.lessons.create') }}">+ Les aanmaken</a></p>

    @if ($lessons->isEmpty())
        <p class="empty">Er zijn geen komende lessen.</p>
    @else
        <div class="tw">
            <table>
                <tr><th>Les</th><th>Datum</th><th>Trainer</th><th>Inschr.</th><th>Acties</th></tr>
                @foreach ($lessons as $lesson)
                    <tr>
                        <td>{{ $lesson->name }}</td>
                        <td>{{ $lesson->date->format('d-m-Y') }} · {{ $lesson->start_label }}</td>
                        <td>{{ $lesson->trainer->name }}</td>
                        <td>{{ $lesson->participants_count }}/{{ $lesson->max_amount }}</td>
                        <td><a class="btn s o" href="{{ route('admin.lessons.edit', $lesson) }}">Wijzig</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif
@endsection
