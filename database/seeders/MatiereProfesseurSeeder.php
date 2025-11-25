<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Professeur;
use App\Models\Matiere;

class MatiereProfesseurSeeder extends Seeder
{
    public function run(): void
    {
        // récupère quelques professeurs et matières
        $profs = Professeur::all();
        $matieres = Matiere::all();

        if ($profs->count() === 0 || $matieres->count() === 0) {
            return;
        }

        // Exemples d'assignations simples
        // Professeur 1 enseigne matière 1 et 3, etc.
        $mapping = [
            0 => [0, 2], // premier prof -> matiere 0 et 2
            1 => [1, 2], // deuxième prof -> matiere 1 et 2
            2 => [3, 4], // troisième prof -> matiere 3 et 4
        ];

        foreach ($mapping as $profIndex => $matiereIndexes) {
            $prof = $profs->get($profIndex);
            $ids = [];
            foreach ($matiereIndexes as $mi) {
                $matiere = $matieres->get($mi) ?? null;
                if ($matiere) $ids[] = $matiere->id_matiere;
            }
            if ($prof && count($ids)) {
                $prof->matieres()->syncWithoutDetaching($ids);
            }
        }
    }
}
