@extends('layouts.app')

@section('content')
    <div class="side">
        @include('partials.trainer-menu')
        <div>
            @yield('trainer')
        </div>
    </div>
@endsection
