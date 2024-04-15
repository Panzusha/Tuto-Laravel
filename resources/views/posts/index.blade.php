<x-default-layout>
    <div class="space-y-10 md:space-y-16">
        {{-- forelse mélange foreach and ifelse --}}
        @forelse ($posts as $post)
        {{-- <x-post :post="$post" /> version sans raccourci --}}
        {{-- list utilise le booléen définit dans post.blade.php --}}
        <x-post :$post list />

        {{-- Affiche un texte en cas de recherche infructueuse --}}
        @empty 
        <p class="text-slate-400 text-center">Aucun résultat</p>

        @endforelse
        {{ $posts->links() }}
    </div>
</x-default-layout>