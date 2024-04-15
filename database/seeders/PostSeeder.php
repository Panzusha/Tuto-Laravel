<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $tags = Tag::all();
        $users = User::all();

        Post::factory(20)
            // sequence sera appellée 20 fois pour donner une categ au hasard (random) lors de la création des posts
            ->sequence(fn () => [
                'category_id' => $categories->random(),
            ])
            
            // méthode magique, détecte la relation pour attribuer des commentaires aux posts
            // fonction fléchée pour affecter un user random à chaque commentaire crée
            ->hasComments(5, fn () => ['user_id' => $users->random()])

            ->create()
            // tags() est la fonction de belongs to many dans Post.php
            // attach pour lier les tags sur les posts
            // assignation d'un nombre aléatoire (0 a 3) de tags aux posts
            ->each(fn ($post) => $post->tags()->attach($tags->random(rand(0, 3))));
    }
}