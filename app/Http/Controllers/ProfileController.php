<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/** Mijn Profiel (leden) / Profiel (trainers): gegevens, foto en wachtwoord wijzigen. */
class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();

        return view('profile.edit', [
            'user' => $user,
            'profile' => $user->role === 'trainer' ? $user->trainer : $user->participant,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $isParticipant = $user->role === 'participant';
        $profile = ($isParticipant ? $user->participant : $user->trainer) ?? abort(403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => $isParticipant ? ['nullable', 'string', 'max:255'] : ['prohibited'],
            'password' => ['nullable', 'string', 'min:8'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $userData = ['name' => $data['name']];

        if (! empty($data['password'])) {
            $userData['password'] = $data['password'];
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $userData['photo'] = $request->file('photo')->store('profile-photos', 'public');
        }

        $user->update($userData);

        $profileData = ['name' => $data['name'], 'phone' => $data['phone'] ?? null];
        if ($isParticipant) {
            $profileData['address'] = $data['address'] ?? null;
        }
        $profile->update($profileData);

        return back()->with('success', 'Uw gegevens zijn opgeslagen.');
    }
}
