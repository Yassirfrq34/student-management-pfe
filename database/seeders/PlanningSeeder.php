<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Planning;
use App\Models\Etudiant;
use App\Models\Matiere;
use Carbon\Carbon;

class PlanningSeeder extends Seeder
{
    public function run(): void
    {
        $etudiants = Etudiant::all();
        $matieres = Matiere::all();

        if ($etudiants->count() === 0 || $matieres->count() === 0) {
            return;
        }

        // Créer 2 créneaux par étudiant
        foreach ($etudiants as $et) {
            $sampleMatieres = $matieres->random(min(2, $matieres->count()));
            $days = [1, 2, 3, 4, 5]; // lundi..vendredi
            foreach ($sampleMatieres as $index => $m) {
                $jour = Carbon::now()->addDays($days[$index % count($days)])->format('Y-m-d');
                $horaire = ($index % 2 == 0) ? '09:00:00' : '14:00:00';
                Planning::create([
                    'id_etudiant' => $et->id_etudiant,
                    'id_matiere' => $m->id_matiere,
                    'jour' => $jour,
                    'horaire' => $horaire,
                ]);
            }
        }
    }
}
