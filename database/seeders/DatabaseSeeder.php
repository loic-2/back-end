<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Activite;
use App\Models\Assureur;
use App\Models\Client;
use App\Models\Personne;
use App\Models\Personnel;
use App\Models\Tache;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        //Activite::factory(15)->create();
        //Personne::factory(40)->create();
        //Assureur::factory(15)->create();
        Personnel::factory(25)->create();
        //Tache::factory(10)->create();
        //Client::factory(10)->create();
    }
}
