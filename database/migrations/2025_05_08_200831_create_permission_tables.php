<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('guard_name'); // Guard a cui si applica
            $table->unique(['name', 'guard_name']); // Assicura unicità
            $table->timestamps();

        });

        Schema::create('roles', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('guard_name');
            $table->unique(['name', 'guard_name']); // Assicura unicità
            $table->timestamps();

        });

        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->foreignUlid('permission_id') // Nuovo: foreign key ULID
                ->constrained('permissions') // Assicura che esista nella tabella permissions
                ->onDelete('cascade');

            $table->string('model_type');
            $table->ulid('model_id');
            $table->index(['model_id', 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->primary(['permission_id', 'model_id', 'model_type'], 'model_has_permissions_permission_model_type_primary');
            $table->timestamps();

        });

        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->foreignUlid('role_id') // Nuovo: foreign key ULID
                ->constrained('roles') // Assicura che esista nella tabella roles
                ->onDelete('cascade');

            $table->string('model_type');
            $table->ulid('model_id');
            $table->index(['model_id', 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->primary(['role_id', 'model_id', 'model_type'], 'model_has_roles_role_model_type_primary');
            $table->timestamps();
        });

        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->foreignUlid('permission_id') // Nuovo: foreign key ULID
            ->constrained('permissions')
                ->onDelete('cascade');

            $table->foreignUlid('role_id') // Nuovo: foreign key ULID
            ->constrained('roles')
                ->onDelete('cascade');


            $table->primary(['permission_id', 'role_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('model_has_permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
    }
};
