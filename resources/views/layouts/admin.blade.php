@extends('layouts.app')

@section('content')
    <div class="side">
        @include('partials.admin-menu')
        <div>
            @yield('admin')
        </div>
    </div>
@endsection
