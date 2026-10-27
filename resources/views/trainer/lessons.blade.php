@extends('layouts.trainer')

@section('title', 'Mijn lessen')

@section('trainer')
    <h1>Mijn lessen</h1>
    @include('partials.trainer-lessons-table', ['lessons' => $lessons])
@endsection
