<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtudiantsTable extends Migration
{
    public function up()
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id('id_etudiant');          // primary key named id_etudiant (BIGINT UNSIGNED)
            $table->string('nom');              // student last name
            $table->string('prenom');           // student first name
            $table->string('email')->unique();  // email must be unique
            $table->string('mot_de_passe');     // password (we'll store bcrypt hash)
            $table->timestamps();               // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('etudiants');
    }
}
