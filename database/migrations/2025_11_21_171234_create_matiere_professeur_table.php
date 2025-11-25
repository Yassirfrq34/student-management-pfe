<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatiereProfesseurTable extends Migration
{
    public function up()
    {
        Schema::create('matiere_professeur', function (Blueprint $table) {
            $table->id();                                 // pivot id (optional)
            $table->unsignedBigInteger('id_professeur'); // FK to professeurs
            $table->unsignedBigInteger('id_matiere');    // FK to matieres
            $table->timestamps();

            // foreign keys
            $table->foreign('id_professeur')->references('id_professeur')->on('professeurs')->onDelete('cascade');
            $table->foreign('id_matiere')->references('id_matiere')->on('matieres')->onDelete('cascade');

            // prevent duplicates: a prof cannot be attached to same matiere twice
            $table->unique(['id_professeur', 'id_matiere']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('matiere_professeur');
    }
}
