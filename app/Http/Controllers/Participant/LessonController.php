<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    /** Lesoverzicht: alle komende lessen met Inschrijven / Afmelden. */
    public function index(Request $request): View
    {
        $participant = $request->user()->participant ?? abort(403);

        return view('participant.lessons', [
            'lessons' => Lesson::upcoming()
                ->with(['trainer', 'location'])
                ->withCount('participants')
                ->chronological()
                ->get(),
            'enrolledIds' => $participant->lessons()->pluck('lesson.id')->all(),
        ]);
    }

    /** Mijn lessen: alles waarvoor dit lid is ingeschreven. */
    public function mine(Request $request): View
    {
        $participant = $request->user()->participant ?? abort(403);

        return view('participant.my-lessons', [
            'lessons' => $participant->lessons()
                ->with(['trainer', 'location'])
                ->chronological()
                ->get(),
        ]);
    }

    public function enroll(Request $request, Lesson $lesson): RedirectResponse
    {
        $participant = $request->user()->participant ?? abort(403);

        abort_if($lesson->date->lt(today()), 404);

        return DB::transaction(function () use ($participant, $lesson) {
            // Rij vergrendelen zodat twee leden niet tegelijk de laatste plaats pakken.
            $lesson = Lesson::lockForUpdate()->findOrFail($lesson->id);

            if ($participant->lessons()->where('lesson.id', $lesson->id)->exists()) {
                return back()->with('error', 'U bent al ingeschreven voor deze les.');
            }

            // Controle uit de wireframe: geen dubbele tijden toestaan.
            if ($participant->hasConflictWith($lesson)) {
                return back()->with('error', 'U bent al ingeschreven voor een les op dit tijdstip.');
            }

            if ($lesson->participants()->count() >= $lesson->max_amount) {
                return back()->with('error', 'Deze les is vol.');
            }

            $participant->lessons()->attach($lesson->id);

            return back()->with('success', 'U bent ingeschreven voor '.$lesson->name.'.');
        });
    }

    public function withdraw(Request $request, Lesson $lesson): RedirectResponse
    {
        $participant = $request->user()->participant ?? abort(403);

        $participant->lessons()->detach($lesson->id);

        return back()->with('success', 'U bent afgemeld voor '.$lesson->name.'.');
    }
}
