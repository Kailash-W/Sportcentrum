@php
    // Menu links uit de wireframe (trainerdashboard)
    $groups = [
        ['Mijn lessen', 'trainer.lessons.index', 'Lessen bekijken'],
        ['Lesdetails', 'trainer.lessons.index', 'Details van een les'],
        ['Deelnemers', 'trainer.participants', 'Deelnemerslijst'],
        ['Agenda', 'trainer.agenda', 'Weekrooster'],
    ];
@endphp
<aside class="menu">
    @foreach ($groups as [$title, $route, $sub])
        <b><a href="{{ route($route) }}">{{ $title }}</a></b>
        <a class="sub" href="{{ route($route) }}">{{ $sub }}</a>
    @endforeach
</aside>
