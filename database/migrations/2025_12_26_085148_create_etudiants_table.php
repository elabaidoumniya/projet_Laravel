<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtudiantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('cin', 8)->unique();  
            $table->string('nom', 50);
            $table->string('prenom', 50);
            $table->string('email')->unique();  
            $table->enum('filiere', ['GINF', 'GINDUS', 'G3EI', 'GCYBER', 'GSEA']);
            $table->enum('niveau', ['AP1', 'AP2', '1AC','2AC','3AC']);
            $table->date('date_naissance');
            $table->string('photo')->nullable();  
            $table->string('telephone', 10)->nullable();
            $table->text('adresse')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etudiants');
    }
}