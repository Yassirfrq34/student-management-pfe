<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;
use App\Models\Etudiant;
use App\Models\Matiere;
use App\Models\Professeur;

class NotesSeeder extends Seeder
{
    public function run(): void
    {
        $etudiants = Etudiant::all();
        $matieres = Matiere::all();
        $profs = Professeur::all();

        if ($etudiants->count() === 0 || $matieres->count() === 0) {
            return;
        }

        // pour chaque étudiant, créer quelques notes aléatoires
        foreach ($etudiants as $et) {
            // choisir 2 matières aléatoires par étudiant
            $sampleMatieres = $matieres->random(min(2, $matieres->count()));
            foreach ($sampleMatieres as $m) {
                Note::create([
                    'valeur' => round(mt_rand(80, 200) / 10, 1), // note entre 8.0 et 20.0
                    'id_matiere' => $m->id_matiere,
                    'id_etudiant' => $et->id_etudiant,
                    'id_professeur' => $profs->random()->id_professeur ?? null,
                ]);
            }
        }
    }
}
