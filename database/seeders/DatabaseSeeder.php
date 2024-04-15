<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(20)->create();

        // on met catégories/tags avant car Post aura besoin d'elles
        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
            PostSeeder::class, 
        ]);
    }
}
