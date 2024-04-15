<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    // vue sur template index ( et pagination) + requete pour le formulaire de recherche
    public function index(Request $request): View
    {
        return $this->postsView($request->search ? ['search' => $request->search] : []);

        // ancienne version avant factorisation (voir Post.php)
        // $posts = Post::query();
        // // search est également le name du formulaire dans le template default.blade.php
        // if ($search = $request->search) {
        //     // modulo(%) indique que la valeur recherchée peut se trouver partout
        //     // recherche dans les colonnes BBD title et content
        //     // Builder $query permet d'isoler les where en cas d'ajout d'autres + tard ( il les place dans une parenthèse au niveau des queries visible dans la BarryVDH debug bar )
        //     $posts->where(fn (Builder $query) => $query
        //         ->where('title', 'LIKE', '%' . $search . '%')
        //         ->orWhere('content', 'LIKE', '%' . $search . '%')
        //     );
        // }

        // // utilisation de $posts = Post::query(); pour afficher la vue
        // return view('posts.index', [
        //     'posts' => $posts->latest()->paginate(5),
        // ]);
    }

    // vue des catégories filtrées
    public function postsByCategory(Category $category): View
    {
        return $this->postsView(['category' => $category]);

        // ancienne version avant factorisation (voir Post.php)
        // return view('posts.index', [
        //     // 'posts' => $category->posts()->latest()->paginate(5), façon de faire originelle
        //     'posts' => Post::where( // clause where pour comparer colonne<>valeur (opérateur 'égal' par défaut)
        //         'category_id', $category->id
        //     )->latest()->paginate(5),
        // ]);
    }

    // vue des tags filtrées
    public function postsByTag(Tag $tag): View
    {
        return $this->postsView(['tag' => $tag]);

        // ancienne version avant factorisation (voir Post.php)
        // return view('posts.index', [
        //     // 'posts' => $tag->posts()->latest()->paginate(5), façon de faire originelle
        //     // clause whereRelation pour comparer colonne<>valeur (opérateur 'égal' par défaut)
        //     'posts' => Post::whereRelation(
        //         'tags', 'tags.id', $tag->id
        //     )->latest()->paginate(5),
        // ]);
    }

    protected function postsView(array $filters): View
    {
        return view('posts.index', [
            // méthode filters existe grace à scopeFilters dans post.php
            // tableau filters transmis a scopeFilters dans Post.php
            'posts' => Post::filters($filters)->latest()->paginate(5),
        ]);
    }

    // vue quand on clique sur un article
    public function show(Post $post): View
    {
        return view('posts.show', [
            'post' => $post,
        ]);
    }

    // poster un comment
    public function comment(Post $post, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'comment' => ['required', 'string', 'between:2,255'],
        ]);

        // façon par défaut de créer une nouvelle entrée dans une table (sans le mass assignment qui est désactivé par défaut)
        // $comment = new Comment();
        // $comment->content = $validated['comment'];
        // $comment->post_id = $post->id;
        // $comment->user_id = Auth::id();
        // $comment->save;

        // façon laravel
        Comment::create([
            'content' => $validated['comment'],
            'post_id' => $post->id,
            'user_id' => Auth::id(),
        ]);

        // return back() renvoie a la derniere page, session flash withStatus réfère a @if (session('status')) de default.blade.php
        return back()->withStatus('Commentaire publié');

    }
}
