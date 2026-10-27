<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/** Activiteitenbeheer: activiteit toevoegen / wijzigen / verwijderen. */
class ActivityController extends Controller
{
    public function index(): View
    {
        return view('admin.activities.index', [
            'activities' => Activity::orderBy('date')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.activities.form', ['activity' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        Activity::create($this->validated($request));

        return redirect()->route('admin.activities.index')->with('success', 'Activiteit toegevoegd.');
    }

    public function edit(Activity $activity): View
    {
        return view('admin.activities.form', ['activity' => $activity]);
    }

    public function update(Request $request, Activity $activity): RedirectResponse
    {
        $activity->update($this->validated($request));

        return redirect()->route('admin.activities.index')->with('success', 'Activiteit gewijzigd.');
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->delete();

        return redirect()->route('admin.activities.index')->with('success', 'Activiteit verwijderd.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'date' => ['nullable', 'date'],
        ]);
    }
}
