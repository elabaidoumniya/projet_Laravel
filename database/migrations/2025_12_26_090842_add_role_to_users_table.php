<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  // Dans la migration add_role_to_users_table
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->enum('role', ['admin', 'etudiant'])->default('etudiant');
        $table->foreignId('etudiant_id')->nullable()->constrained('etudiants')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['etudiant_id']);
        $table->dropColumn(['role', 'etudiant_id']);
    });
}
}
   

