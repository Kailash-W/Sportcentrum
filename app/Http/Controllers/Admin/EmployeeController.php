<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Lesson;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/** Medewerkerbeheer: toevoegen / wijzigen / verwijderen en koppelen aan lessen. */
class EmployeeController extends Controller
{
    public function index(): View
    {
        return view('admin.employees.index', [
            'employees' => Employee::withCount('lessons')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.employees.form', ['employee' => null, 'lessons' => $this->lessonChoices()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $employee = Employee::create(['name' => $data['name'], 'position' => $data['position']]);
        $this->syncLessons($employee, $data['lessons'] ?? []);

        return redirect()->route('admin.employees.index')->with('success', 'Medewerker toegevoegd.');
    }

    public function edit(Employee $employee): View
    {
        return view('admin.employees.form', [
            'employee' => $employee->load('lessons'),
            'lessons' => $this->lessonChoices(),
        ]);
    }

    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $data = $this->validated($request);

        $employee->update(['name' => $data['name'], 'position' => $data['position']]);
        $this->syncLessons($employee, $data['lessons'] ?? []);

        return redirect()->route('admin.employees.index')->with('success', 'Medewerker gewijzigd.');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'Medewerker verwijderd.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'lessons' => ['nullable', 'array'],
            'lessons.*' => ['integer', 'exists:lesson,id'],
        ]);
    }

    /**
     * Het formulier toont alleen komende lessen. Koppelingen met lessen uit het verleden
     * blijven daarom staan; alleen de komende lessen worden bijgewerkt.
     */
    private function syncLessons(Employee $employee, array $selected): void
    {
        $upcomingIds = Lesson::upcoming()->pluck('lesson.id')->all();

        $keep = $employee->lessons()
            ->whereNotIn('lesson.id', $upcomingIds)
            ->pluck('lesson.id')
            ->all();

        $employee->lessons()->sync(array_unique(array_merge($keep, $selected)));
    }

    private function lessonChoices()
    {
        return Lesson::upcoming()->with('trainer')->chronological()->get();
    }
}
