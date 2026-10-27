<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/** Ledenbeheer: lid toevoegen / wijzigen / verwijderen. */
class ParticipantController extends Controller
{
    public function index(): View
    {
        return view('admin.participants.index', [
            'participants' => Participant::with('user')->withCount('lessons')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.participants.form', ['participant' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => User::PARTICIPANT,
            ]);

            Participant::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]);
        });

        return redirect()->route('admin.participants.index')->with('success', 'Lid toegevoegd.');
    }

    public function edit(Participant $participant): View
    {
        return view('admin.participants.form', ['participant' => $participant->load('user')]);
    }

    public function update(Request $request, Participant $participant): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($participant->user_id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        DB::transaction(function () use ($data, $participant) {
            $participant->update([
                'name' => $data['name'],
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]);

            if ($participant->user) {
                $userData = ['name' => $data['name'], 'email' => $data['email']];
                if (! empty($data['password'])) {
                    $userData['password'] = $data['password'];
                }
                $participant->user->update($userData);
            }
        });

        return redirect()->route('admin.participants.index')->with('success', 'Lid gewijzigd.');
    }

    public function destroy(Participant $participant): RedirectResponse
    {
        // Het account verwijderen ruimt het lid en de inschrijvingen op (ON DELETE CASCADE).
        if ($participant->user) {
            $participant->user->delete();
        } else {
            $participant->delete();
        }

        return redirect()->route('admin.participants.index')->with('success', 'Lid verwijderd.');
    }
}
