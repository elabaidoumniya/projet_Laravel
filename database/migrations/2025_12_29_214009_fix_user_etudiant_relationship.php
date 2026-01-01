<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixUserEtudiantRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Ajouter user_id à la table etudiants
        Schema::table('etudiants', function (Blueprint $table) {
            if (!Schema::hasColumn('etudiants', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
        
        // 2. Transférer les données si elles existent déjà
        // Cette partie récupère les associations existantes entre users et etudiants
        // via la colonne etudiant_id dans users, et les met dans la nouvelle colonne user_id dans etudiants
        try {
            DB::statement('
                UPDATE etudiants e
                INNER JOIN users u ON u.etudiant_id = e.id
                SET e.user_id = u.id
                WHERE e.user_id IS NULL
            ');
        } catch (\Exception $e) {
            // Ignore si erreur (pas de données à transférer)
        }
        
        // 3. Supprimer etudiant_id de la table users
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'etudiant_id')) {
                $table->dropForeign(['etudiant_id']);
                $table->dropColumn('etudiant_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 1. Rétablir etudiant_id dans users
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'etudiant_id')) {
                $table->foreignId('etudiant_id')->nullable()->constrained('etudiants')->onDelete('cascade');
            }
        });
        
        // 2. Transférer les données en sens inverse
        try {
            DB::statement('
                UPDATE users u
                INNER JOIN etudiants e ON e.user_id = u.id
                SET u.etudiant_id = e.id
                WHERE u.etudiant_id IS NULL
            ');
        } catch (\Exception $e) {
            // Ignore si erreur
        }
        
        // 3. Supprimer user_id de etudiants
        Schema::table('etudiants', function (Blueprint $table) {
            if (Schema::hasColumn('etudiants', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
}