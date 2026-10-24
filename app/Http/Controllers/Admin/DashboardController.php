<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Employee;
use App\Models\Lesson;
use App\Models\Participant;
use App\Models\Trainer;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'counts' => [
                'Leden' => Participant::count(),
                'Trainers' => Trainer::count(),
                'Medewerkers' => Employee::count(),
                'Komende lessen' => Lesson::upcoming()->count(),
                'Activiteiten' => Activity::count(),
            ],
            'lessons' => Lesson::upcoming()
                ->with(['trainer', 'location'])
                ->withCount('participants')
                ->chronological()
                ->take(5)
                ->get(),
        ]);
    }
}
