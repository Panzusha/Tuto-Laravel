<x-auth-layout title="Inscription" :action="route('register')" submitMessage="Inscription">
    <x-input name="name" label="Nom complet" />
    <x-input name="email" label="Adresse e-mail" type="email" />
    <x-input name="password" label="Mot de passe" type="password" />
    {{-- le champ de confirmation doit avoir le même nom (ici = password) --}}
    <x-input name="password_confirmation" label="Confirmation du mot de passe" type="password" />
</x-auth-layout>