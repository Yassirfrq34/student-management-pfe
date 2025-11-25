<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanningsTable extends Migration
{
    public function up()
    {
        Schema::create('plannings', function (Blueprint $table) {
            $table->id('id_planning');
            $table->unsignedBigInteger('id_etudiant');   // student
            $table->unsignedBigInteger('id_matiere');    // subject
            $table->date('jour');                        // day
            $table->time('horaire');                     // time
            $table->timestamps();

            $table->foreign('id_etudiant')->references('id_etudiant')->on('etudiants')->onDelete('cascade');
            $table->foreign('id_matiere')->references('id_matiere')->on('matieres')->onDelete('cascade');

            // prevent duplicate identical slots for same student+day+time+matiere
            $table->unique(['id_etudiant', 'jour', 'horaire', 'id_matiere'], 'unique_planning_slot');
        });
    }

    public function down()
    {
        Schema::dropIfExists('plannings');
    }
}
