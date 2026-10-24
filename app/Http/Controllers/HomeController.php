<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Employee;
use App\Models\Lesson;
use App\Models\Trainer;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'activities' => Activity::orderBy('date')->take(3)->get(),
            'popularLessons' => Lesson::upcoming()
                ->with('trainer')
                ->withCount('participants')
                ->orderByDesc('participants_count')
                ->chronological()
                ->take(3)
                ->get(),
            'trainers' => Trainer::with('user')->orderBy('name')->take(4)->get(),
            'employees' => Employee::orderBy('name')->take(4)->get(),
        ]);
    }

    public function privacy(): View
    {
        return view('page', [
            'title' => 'Privacybeleid',
            'paragraphs' => [
                'Sportcentrum De Linde gebruikt uw gegevens (naam, adres, telefoonnummer en e-mailadres) alleen om uw lidmaatschap en lesinschrijvingen te beheren.',
                'Wij delen uw gegevens niet met derden. U kunt uw gegevens op ieder moment bekijken en wijzigen via Mijn Profiel.',
                'Vragen over uw gegevens? Mail naar info@delinde.nl.',
            ],
        ]);
    }

    public function terms(): View
    {
        return view('page', [
            'title' => 'Algemene voorwaarden',
            'paragraphs' => [
                'Door een account aan te maken wordt u lid van Sportcentrum De Linde.',
                'U kunt zich inschrijven voor lessen zolang er plaatsen vrij zijn. Inschrijven voor twee lessen op hetzelfde tijdstip is niet mogelijk.',
                'Afmelden voor een les kan op ieder moment via het lesoverzicht.',
            ],
        ]);
    }
}
