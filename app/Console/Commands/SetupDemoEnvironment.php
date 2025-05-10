<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;
use Symfony\Component\Console\Command\Command as CommandAlias;

class SetupDemoEnvironment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup-demo-environment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Esegue seeder iniziali se necessario e avvia il server locale su porta 8003';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🔍 Verifica se ruoli e permessi esistono...');

        $rolesCount = DB::table('roles')->count();
        $usersCount = DB::table('users')
            ->where('email', 'admin@example.com')
            ->count();

        if ($rolesCount === 0 || $usersCount === 0) {
            $this->warn('📦 Ruoli o utenti demo non trovati. Eseguo i seeder...');

            // ✅ Svuota cache Spatie
            app()[PermissionRegistrar::class]->forgetCachedPermissions();
            $this->info('🧹 Cache permessi pulita');

            // 🔁 Esegui seeder
            Artisan::call('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
            $this->line(Artisan::output());

            Artisan::call('db:seed', ['--class' => 'UsersWithRolesSeeder']);
            $this->line(Artisan::output());

            $this->info('✅ Seeder completati.');
        } else {
            $this->info('✅ Ruoli e utenti demo già presenti. Seeder saltati.');
        }

        $this->info('🚀 Avvio server su porta 8003...');
        passthru('php artisan serve --port=8003');

        return CommandAlias::SUCCESS;
    }
}
