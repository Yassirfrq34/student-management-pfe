<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Etudiant;

class EtudiantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            ['nom'=>'Dupont', 'prenom'=>'Alice', 'email'=>'alice@example.test', 'mot_de_passe'=>bcrypt('password')],
            ['nom'=>'Martin', 'prenom'=>'Bob', 'email'=>'bob@example.test', 'mot_de_passe'=>bcrypt('password')],
            ['nom'=>'Nguyen', 'prenom'=>'Lina', 'email'=>'lina@example.test', 'mot_de_passe'=>bcrypt('password')],
            ['nom'=>'Kass', 'prenom'=>'Yassir', 'email'=>'yassir@example.test', 'mot_de_passe'=>bcrypt('password')],
            ['nom'=>'El Hilali', 'prenom'=>'Zyad', 'email'=>'zyad@example.test', 'mot_de_passe'=>bcrypt('password')],
        ];

        foreach ($students as $s) {
            Etudiant::create($s);
        }
    }
}
