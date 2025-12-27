<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeFiliereNullableInEtudiantsTable extends Migration
{
    public function up()
    {
        Schema::table('etudiants', function (Blueprint $table) {
            // Changer la colonne filiere pour permettre null
            $table->string('filiere', 50)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('etudiants', function (Blueprint $table) {
            $table->string('filiere', 50)->nullable(false)->change();
        });
    }
}