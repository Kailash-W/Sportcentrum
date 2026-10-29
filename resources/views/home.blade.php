@extends('layouts.app')

@section('content')
    @php
        $hero = file_exists(public_path('//public/images/hero.jpg')) ? asset('//public/images/hero.jpg') : null;
    @endphp

    <div class="hero" @if ($hero) style="background-image:url('{{ $hero }}')" @endif>
        <div class="tx">
            <h1>Welkom bij De Linde</h1>
            <p>Sport, beweeg en ontmoet. Voor elk niveau.</p>
        </div>
    </div>

    <div class="actions">
        @guest
            <a class="btn" href="{{ route('register') }}">Word lid</a>
            <a class="btn o" href="{{ route('login') }}">Bekijk lessen</a>
        @else
            <a class="btn" href="{{ auth()->user()->homeUrl() }}">Naar mijn dashboard</a>
            @if (auth()->user()->role === 'participant')
                <a class="btn o" href="{{ route('participant.lessons.index') }}">Bekijk lessen</a>
            @endif
        @endguest
    </div>

    <h2>Onze activiteiten</h2>
    @if ($activities->isEmpty())
        <p class="empty">Er zijn nog geen activiteiten toegevoegd.</p>
    @else
        <div class="grid g3">
            @foreach ($activities as $activity)
                <div class="card">
                    <div class="photo">🏊🏻‍♂️🧘🏻‍♂️🏋🏻‍♂️</div>
                    <h3 style="margin-top:8px">{{ $activity->name }}</h3>
                    <p style="margin:0">{{ $activity->description }}</p>
                    @if ($activity->date)
                        <p><small>{{ $activity->date->format('d-m-Y') }}</small></p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <div class="contact-container">
    <h2 class="section" id="contact">Contact</h2>
    <p>info@delinde.nl · 012-3456789 · Lindelaan 1, Breda</p>
    </div>
@endsection
