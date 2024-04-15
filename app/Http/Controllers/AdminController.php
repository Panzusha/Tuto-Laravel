<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.posts.index', [
            // Post::without indique que l'on ne veut pas charger le contenu des relations categs et tags
            'posts' => Post::without('category', 'tags')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // correspond au chemin+nom du fichier template
        return view('admin.posts.form', [
            // on recup les listes pour l'itération du menu select (formulaire création de post)
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(), 
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    // demande sera rejetée si non validée par la fonction rules de la classe PostRequest
    public function store(PostRequest  $request)
    {
        $validated = $request->validated();

        // les fichiers validés du champ vignette seront stockés dans storage/app/public/thumbnails
        // le sous dossier thumbnails sera crée en fonction du nom donné en paramètres de ->store('')
        // $validated['thumbnail'] devient le chemin qui mène à la vignette
        $validated['thumbnail'] = $validated['thumbnail']->store('thumbnails');
        // création de l'extrait, tiré du contenu de l'article
        $validated['excerpt'] = Str::limit($validated['content'], 150);

        // creation du post en utilisant le modèle
        $post = Post::create($validated);

        // on utilise la relation tags définie dans Post.php / ?? null si aucun tag n'est renseigné
        // sync synchronise les tags et les posts dans la table pivot
        // si un post a les tags A et B , et qu'on le met a jour avec C et D, sync enlevera les 2 anciens
        $post->tags()->sync($validated['tag_ids'] ?? null);

        // redirection vers le post qui vient d être crée
        return redirect()->route('posts.show', ['post' => $post])->withStatus('Post publié !');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
