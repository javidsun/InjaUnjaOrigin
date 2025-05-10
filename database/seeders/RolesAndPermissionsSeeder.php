<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

// php artisan make:seeder RolesAndPermissionsSeeder

// esegui il seeder
//php artisan migrate:fresh --seed

// php artisan db:seed --class=RolesAndPermissionsSeeder
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ✅ 1. Pulisci la cache di Spatie
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ✅ 2. Definisci i permessi
        $permissions = [
            'view dashboard',
            'manage users',
            'create announcement',
            'edit announcement',
            'delete announcement',
            'assign roles',
        ];

        foreach ($permissions as $perm) {
            Permission::findOrCreate(trim($perm), 'web');
        }

        // ✅ 3. Definisci i ruoli
        $admin = Role::findOrCreate('admin', 'web');
        $host  = Role::findOrCreate('host', 'web');
        $guest = Role::findOrCreate('guest', 'web');

        // ✅ 4. Assegna i permessi ai ruoli
        $admin->syncPermissions(Permission::all());

        $host->syncPermissions([
            'create announcement',
            'edit announcement',
        ]);

        $guest->syncPermissions([]); // Nessun permesso iniziale

        $this->command->info('✅ Ruoli e permessi creati con successo.');
    }

    //TODO : dopo di questo ho lanciato "php artisan db:seed --class=RolesAndPermissionsSeeder"
}
