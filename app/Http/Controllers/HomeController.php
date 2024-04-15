<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home.index');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => [
                'required', 
                'string',
                // fonction (custom validation rule) pour vérifier si le mdp est bien l'actuel
                // $attribute = current password, $value = valeur mdp entrée par le user,
                // si Closure est appellée ($fail), invalidation
                function (string $attribute, mixed $value, Closure $fail) use ($user) {
                    // vérifie si $value (valeur tapée dans le champ par le user) correspond au mdp de l'utilisateur 
                    // connecté (Auth::user/$user) dans la BDD
                    // "!" pour que si ca retourne true, on envoie $fail
                    if (! Hash::check($value, $user->password)) {
                        // pourrait être {$attribute} mais on veut que laravel fasse la traduction de "current password"
                        // afin que le msg d'erreur soit entièrement en français
                        $fail("Le :attribute est erroné.");
                    }
                },
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        // MaJ du mdp (ne pas tenir compte de l'erreur)
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        // redirection page compte de l'utilisateur
        return redirect()->route('home')->withStatus('Mot de passe modifié');
    }
}
