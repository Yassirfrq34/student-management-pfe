<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matiere;

class MatiereSeeder extends Seeder
{
    public function run(): void
    {
        $matieres = [
            ['nom' => 'Mathematiques'],
            ['nom' => 'Physique'],
            ['nom' => 'Informatique'],
            ['nom' => 'Chimie'],
            ['nom' => 'Anglais'],
        ];

        foreach ($matieres as $m) {
            Matiere::create($m);
        }
    }
}
