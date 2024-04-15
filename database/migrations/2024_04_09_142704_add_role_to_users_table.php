<?php

use App\Enums\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // on met les valeurs string des cases de l'enum Role dans un tableau et on y accède (voir Role.php)
            $roles = array_column(Role::cases(), 'value');
            // enum = type de la colonne BDD, role = nom de la colonne, on utilise $roles récupéré ci-dessus
            // after pour indiquer le placement de la colonne dans la table
            // default = valeur par défaut du role, ici on accède à la valeur string du case Default de l'enum Role
            $table->enum('role', $roles)->after('email')->default(Role::Default->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
