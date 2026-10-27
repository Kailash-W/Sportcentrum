<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Contracts\View\View;

class ActivityController extends Controller
{
    public function index(): View
    {
        return view('participant.activities', [
            'activities' => Activity::orderBy('date')->get(),
        ]);
    }
}
