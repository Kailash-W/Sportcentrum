@extends('layouts.app')

@section('title', 'Dashboard lid')

@section('content')
    <h1>Dashboard lid</h1>
    <p>Welkom {{ auth()->user()->name }}. Hier komt straks het overzicht voor leden.</p>
@endsection