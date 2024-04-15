<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showRegistrationForm(): View
    {
        // retourne la vue générée par le template register via la route du même nom
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        // validation des champs du formulaire d'inscription (voir doc laravel validation rules)
        // méthode validate gère le retour de page en cas d'erreur dans un des champs
        $validated = $request->validate([
            // between = nb de caratères
            'name' => ['required', 'string', 'between:5,255'],
            // unique : viendra verifier la colonne email dans table users
            'email' => ['required', 'email', 'unique:users'],
            // confirmed indique la présence d'un champ de confirmation
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // les données ci-dessus sont validées, le script passe à la suite
        // clé de hachage sur le mdp
        $validated['password'] = Hash::make($validated['password']);

        // création utilisateur
        // important que les données du tableau validated soient vérifiées ( mass assignment, faille de sécurité potentielle)
        $user = User::create($validated);

        // à partir de la, l'utilisateur est considéré comme authentifié
        Auth::login($user);

        // redirection sur le compte en utilisant la route home
        // utilisation session flash (with)  voir doc laravel et prise de notes page 7
        return redirect()->route('home')->withStatus('Inscription réussie');
    }
}
