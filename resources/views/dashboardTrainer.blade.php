@extends('layouts.app')

@section('title', 'Dashboard trainer')

@section('content')
    <h1>Dashboard trainer</h1>
    <p>Welkom {{ auth()->user()->name }}. Hier komt straks het overzicht voor trainers.</p>
@endsection