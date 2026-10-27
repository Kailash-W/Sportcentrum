@extends('layouts.app')

@section('title', 'Dashboard beheerder')

@section('content')
    <h1>Dashboard beheerder</h1>
    <p>Welkom {{ auth()->user()->name }}. Hier komt straks het beheeroverzicht.</p>
@endsection