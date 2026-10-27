<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Location;
use App\Models\Trainer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/** Lesbeheer: les aanmaken / wijzigen / verwijderen. */
class LessonController extends Controller
{
    public function index(): View
    {
        return view('admin.lessons.index', [
            'lessons' => Lesson::with(['trainer', 'location'])
                ->withCount('participants')
                ->chronological()
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.lessons.form', $this->formData(null));
    }

    public function store(Request $request): RedirectResponse
    {
        Lesson::create($this->validated($request));

        return redirect()->route('admin.lessons.index')->with('success', 'Les aangemaakt.');
    }

    public function edit(Lesson $lesson): View
    {
        return view('admin.lessons.form', $this->formData($lesson));
    }

    public function update(Request $request, Lesson $lesson): RedirectResponse
    {
        $lesson->update($this->validated($request, $lesson));

        return redirect()->route('admin.lessons.index')->with('success', 'Les gewijzigd.');
    }

    public function destroy(Lesson $lesson): RedirectResponse
    {
        // Inschrijvingen en medewerker-koppelingen verdwijnen mee (ON DELETE CASCADE).
        $lesson->delete();

        return redirect()->route('admin.lessons.index')->with('success', 'Les verwijderd.');
    }

    private function formData(?Lesson $lesson): array
    {
        return [
            'lesson' => $lesson,
            'trainers' => Trainer::orderBy('name')->get(),
            'locations' => Location::orderBy('name')->get(),
        ];
    }

    private function validated(Request $request, ?Lesson $lesson = null): array
    {
        // Het maximum mag niet lager worden dan het aantal bestaande inschrijvingen.
        $minimum = max(1, $lesson ? $lesson->participants()->count() : 1);

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'trainer_id' => ['required', 'exists:trainer,id'],
            'location_id' => ['required', 'exists:location,id'],
            'max_amount' => ['required', 'integer', 'min:'.$minimum, 'max:500'],
        ]);
    }
}
