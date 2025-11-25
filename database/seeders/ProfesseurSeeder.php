<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Professeur;

class ProfesseurSeeder extends Seeder
{
    public function run(): void
    {
        $profs = [
            ['nom'=>'Dupont', 'email'=>'dupont@example.test', 'mot_de_passe'=>bcrypt('password')],
            ['nom'=>'Leclerc', 'email'=>'leclerc@example.test', 'mot_de_passe'=>bcrypt('password')],
            ['nom'=>'Benali', 'email'=>'benali@example.test', 'mot_de_passe'=>bcrypt('password')],
        ];

        foreach ($profs as $p) {
            Professeur::create($p);
        }
    }
}
