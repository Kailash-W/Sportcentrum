@php
    // Menu links uit de wireframe (beheerdashboard): titel, routenaam-basis en de acties
    $groups = [
        ['Ledenbeheer', 'admin.participants', [['Lid toevoegen', 'create'], ['Lid wijzigen en verwijderen', 'index'],]],
        ['Trainerbeheer', 'admin.trainers', [['Trainer toevoegen', 'create'], ['Trainer wijzigen en verwijderen', 'index'], ]],
        ['Medewerkerbeheer', 'admin.employees', [['Medewerker toevoegen', 'create'], ['Medewerker koppelen aan lessen, wijzigen en verwijderen', 'index']]],
        ['Lesbeheer', 'admin.lessons', [['Les aanmaken', 'create'], ['Les wijzigen en verwijderen', 'index'], ]],
        ['Activiteitenbeheer', 'admin.activities', [['Activiteit toevoegen', 'create'], ['Activiteit wijzigen en verwijderen', 'index'], ]],
    ];
@endphp
<aside class="menu">
    <b><a href="{{ route('admin.dashboard') }}">Dashboard</a></b>
    @foreach ($groups as [$title, $base, $items])
        <b><a href="{{ route($base.'.index') }}">{{ $title }}</a></b>
        @foreach ($items as [$label, $action])
            <a class="sub" href="{{ route($base.'.'.$action) }}">{{ $label }}</a>
        @endforeach
    @endforeach
</aside>
