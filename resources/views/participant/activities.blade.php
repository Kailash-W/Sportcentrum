@extends('layouts.app')

@section('title', 'Activiteiten')

@section('content')
    <h1>Activiteiten</h1>

    @if ($activities->isEmpty())
        <p class="empty">Er zijn nog geen activiteiten toegevoegd.</p>
    @else
        <div class="grid g3">
            @foreach ($activities as $activity)
                <div class="card">
                    <div class="photo">🏊🏻‍♂️🧘🏻‍♂️🏋🏻‍♂️</div>
                    <h3 style="margin-top:8px">{{ $activity->name }}</h3>
                    <p>{{ $activity->description }}</p>
                    @if ($activity->date)
                        <p><small>{{ $activity->date->format('d-m-Y') }}</small></p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
@endsection
