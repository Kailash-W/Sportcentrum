<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/** Trainerbeheer: trainer toevoegen / wijzigen / verwijderen. */
class TrainerController extends Controller
{
    public function index(): View
    {
        return view('admin.trainers.index', [
            'trainers' => Trainer::with('user')->withCount('lessons')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.trainers.form', ['trainer' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => User::TRAINER,
            ]);

            Trainer::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'phone' => $data['phone'] ?? null,
            ]);
        });

        return redirect()->route('admin.trainers.index')->with('success', 'Trainer toegevoegd.');
    }

    public function edit(Trainer $trainer): View
    {
        return view('admin.trainers.form', ['trainer' => $trainer->load('user')]);
    }

    public function update(Request $request, Trainer $trainer): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($trainer->user_id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        DB::transaction(function () use ($data, $trainer) {
            $trainer->update(['name' => $data['name'], 'phone' => $data['phone'] ?? null]);

            if ($trainer->user) {
                $userData = ['name' => $data['name'], 'email' => $data['email']];
                if (! empty($data['password'])) {
                    $userData['password'] = $data['password'];
                }
                $trainer->user->update($userData);
            }
        });

        return redirect()->route('admin.trainers.index')->with('success', 'Trainer gewijzigd.');
    }

    public function destroy(Trainer $trainer): RedirectResponse
    {
        // lesson.trainer_id heeft geen ON DELETE CASCADE: eerst de lessen aan iemand anders geven.
        if ($trainer->lessons()->exists()) {
            return back()->with('error', 'Deze trainer heeft nog lessen. Wijs die eerst aan een andere trainer toe of verwijder ze.');
        }

        if ($trainer->user) {
            $trainer->user->delete();
        } else {
            $trainer->delete();
        }

        return redirect()->route('admin.trainers.index')->with('success', 'Trainer verwijderd.');
    }
}
