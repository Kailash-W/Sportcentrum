<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $participant = $user->participant ?? abort(403, 'Er is geen lid gekoppeld aan dit account.');

        return view('participant.dashboard', [
            'user' => $user,
            'participant' => $participant,
            'upcoming' => $participant->lessons()
                ->upcoming()
                ->with('location')
                ->chronological()
                ->take(3)
                ->get(),
            'activities' => Activity::orderBy('date')->take(3)->get(),
        ]);
    }
}
