<x-default-layout title="Création d'un post">
    {{-- enctype pour gérer l'envoi de fichier --}}
    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- @method indique a Laravel que l'on veut modifier la method de la balise form car de base seules POST ET
        GET sont possibles dans un formulaire. PATCH applique des modif partielles a une ressource --}}
        {{-- @method('PATCH') --}}
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h1 class="text-base font-semibold leading-7 text-gray-900">Créer un post</h1>
                <p class="mt-1 text-sm leading-6 text-gray-600">Révélez vos talents d'écrivain</p>

                <div class="mt-10 space-y-8 md:w-2/3">
                    {{-- le name correspond au nom de colonne dans la BDD --}}
                    <x-input name="title" label="Titre" />
                    {{-- slug est une string qui est URL friendly (extrait titre dans ce cas précis) --}}
                    <x-input name="slug" label="Slug" help="Laisser vide pour un slug auto.
                    Si une valeur est renseignée, elle sera slugifiée avant d'être soumise à validation" />
                    {{-- utilisation du composant textarea --}}
                    <x-textarea name="content" label="Contenu du post"></x-textarea>
                    {{-- input file thumbnail --}}
                    <x-input name="thumbnail" type="file" label="Vignette" />
                    {{-- ":" indique une expression php , ici :list nous permet d'itérer dans la BDD (fonction index de AdminController.php) --}}
                    <x-select name="category_id" label="Catégorie" :list="$categories" />
                    {{-- même commentaire que ci dessus mais pour les tags --}}
                    <x-select name="tag_ids" label="Etiquettes" :list="$tags" multiple />
                </div>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white 
            shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 
            focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Publier</button>
        </div>
    </form>
</x-default-layout>