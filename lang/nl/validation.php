<?php

return [
    'after' => ':Attribute moet later zijn dan :date.',
    'array' => ':Attribute moet een lijst zijn.',
    'confirmed' => 'De bevestiging van :attribute komt niet overeen.',
    'date' => ':Attribute is geen geldige datum.',
    'date_format' => ':Attribute moet het formaat :format hebben.',
    'email' => ':Attribute moet een geldig e-mailadres zijn.',
    'exists' => 'De gekozen :attribute is ongeldig.',
    'image' => ':Attribute moet een afbeelding zijn.',
    'integer' => ':Attribute moet een geheel getal zijn.',
    'prohibited' => ':Attribute is niet toegestaan.',
    'required' => ':Attribute is verplicht.',
    'string' => ':Attribute moet tekst zijn.',
    'unique' => ':Attribute is al in gebruik.',
    'uploaded' => ':Attribute kon niet worden geüpload.',

    'min' => [
        'numeric' => ':Attribute moet minimaal :min zijn.',
        'string' => ':Attribute moet minimaal :min tekens bevatten.',
    ],
    'max' => [
        'numeric' => ':Attribute mag niet groter zijn dan :max.',
        'string' => ':Attribute mag niet meer dan :max tekens bevatten.',
        'file' => ':Attribute mag niet groter zijn dan :max kilobytes.',
    ],

    'attributes' => [
        'name' => 'naam',
        'email' => 'e-mailadres',
        'password' => 'wachtwoord',
        'address' => 'adres',
        'phone' => 'telefoonnummer',
        'photo' => 'foto',
        'position' => 'functie',
        'description' => 'beschrijving',
        'date' => 'datum',
        'start_time' => 'starttijd',
        'end_time' => 'eindtijd',
        'max_amount' => 'maximum aantal deelnemers',
        'trainer_id' => 'trainer',
        'location_id' => 'zaal',
        'lessons' => 'lessen',
    ],
];
