<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Vul je e-mailadres in.',
            'email.email'       => 'Dit is geen geldig e-mailadres.',
            'password.required' => 'Vul je wachtwoord in.',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'E-mailadres of wachtwoord is onjuist.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route($this->routeForRole(Auth::user()->role));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /**
     * Bepaalt naar welke pagina een gebruiker gaat op basis van zijn rol.
     */
    public static function routeForRole(string $role): string
    {
        return match ($role) {
            'beheerder' => 'beheerder.dashboard',
            'trainer'   => 'trainer.dashboard',
            default     => 'lid.dashboard',
        };
    }
}