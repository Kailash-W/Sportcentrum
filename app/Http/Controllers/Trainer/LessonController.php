<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /** Dashboard: komende lessen + details/deelnemers van de eerstvolgende les. */
    public function dashboard(Request $request): View
    {
        $trainer = $request->user()->trainer ?? abort(403, 'Er is geen trainer gekoppeld aan dit account.');

        $lessons = $trainer->lessons()
            ->upcoming()
            ->with('location')
            ->withCount('participants')
            ->chronological()
            ->get();

        $next = $lessons->first();

        return view('trainer.dashboard', [
            'lessons' => $lessons,
            'next' => $next,
            'nextParticipants' => $next ? $next->participants()->orderBy('name')->get() : collect(),
        ]);
    }

    /** Mijn Lessen: alle lessen van deze trainer. */
    public function index(Request $request): View
    {
        $trainer = $request->user()->trainer ?? abort(403);

        return view('trainer.lessons', [
            'lessons' => $trainer->lessons()
                ->with('location')
                ->withCount('participants')
                ->chronological()
                ->get(),
        ]);
    }

    /** Knop "Details". */
    public function show(Request $request, Lesson $lesson): View
    {
        $this->authorizeLesson($request, $lesson);

        $lesson->load(['location', 'trainer'])->loadCount('participants');

        return view('trainer.lesson-show', ['lesson' => $lesson]);
    }

    /** Knop "Deelnemers". */
    public function participants(Request $request, Lesson $lesson): View
    {
        $this->authorizeLesson($request, $lesson);

        $lesson->load('location')->loadCount('participants');

        return view('trainer.lesson-participants', [
            'lesson' => $lesson,
            'participants' => $lesson->participants()->with('user')->orderBy('name')->get(),
        ]);
    }

    /** Menu "Deelnemers": deelnemerslijst per komende les. */
    public function overview(Request $request): View
    {
        $trainer = $request->user()->trainer ?? abort(403);

        return view('trainer.participants', [
            'lessons' => $trainer->lessons()
                ->upcoming()
                ->with(['location', 'participants' => fn ($q) => $q->orderBy('name')])
                ->chronological()
                ->get(),
        ]);
    }

    /** Menu "Agenda": weekrooster (?week=-1, 0, 1, ...). */
    public function agenda(Request $request): View
    {
        $trainer = $request->user()->trainer ?? abort(403);

        $week = (int) $request->query('week', 0);
        $start = now()->startOfWeek()->addWeeks($week);
        $days = collect(range(0, 6))->map(fn ($i) => $start->copy()->addDays($i));

        $lessons = $trainer->lessons()
            ->whereBetween('lesson.date', [$start->toDateString(), $start->copy()->addDays(6)->toDateString()])
            ->with('location')
            ->withCount('participants')
            ->chronological()
            ->get()
            ->groupBy(fn ($lesson) => $lesson->date->toDateString());

        return view('trainer.agenda', [
            'days' => $days,
            'lessons' => $lessons,
            'week' => $week,
        ]);
    }

    private function authorizeLesson(Request $request, Lesson $lesson): void
    {
        $trainer = $request->user()->trainer ?? abort(403);

        abort_unless($lesson->trainer_id === $trainer->id, 403);
    }
}
