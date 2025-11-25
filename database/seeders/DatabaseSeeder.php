<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            EtudiantSeeder::class,
            ProfesseurSeeder::class,
            MatiereSeeder::class,
            MatiereProfesseurSeeder::class,
            NotesSeeder::class,
            PlanningSeeder::class,
        ]);
    }
}
