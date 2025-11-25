<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id('id_note');
            $table->float('valeur');                      // grade value
            $table->unsignedBigInteger('id_matiere');     // references matieres
            $table->unsignedBigInteger('id_etudiant');    // references etudiants
            $table->unsignedBigInteger('id_professeur')->nullable(); // optional who graded
            $table->timestamps();

            $table->foreign('id_matiere')->references('id_matiere')->on('matieres')->onDelete('cascade');
            $table->foreign('id_etudiant')->references('id_etudiant')->on('etudiants')->onDelete('cascade');
            $table->foreign('id_professeur')->references('id_professeur')->on('professeurs')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
