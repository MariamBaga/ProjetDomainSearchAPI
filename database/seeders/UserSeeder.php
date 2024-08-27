<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Assure-toi que ce chemin est correct pour ton modèle User

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crée un utilisateur avec des données spécifiques
        User::create([
            'name' => 'Mariam',
            'email' => 'mariam@gmail.com',
            'password' => Hash::make('password123'), // Assure-toi d'utiliser Hash::make pour le mot de passe
        ]);

        // Crée plusieurs utilisateurs avec des données fictives
        User::factory()->count(10)->create(); // Utilise une factory si tu en as configuré une
    }
}
