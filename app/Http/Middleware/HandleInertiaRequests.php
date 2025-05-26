<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

// TODO : vorrei sapere cosa è questo use e questo middleware non viene chiamato in nessun parte

// Se usi Ziggy per le rotte Laravel in JS

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app'; // guarda il root principale di balde che è all'interno di resources/view/app.blade.

    public function rootView(Request $request): string
    {
        // Per gestire diversi layout root se necessario
        if (str_starts_with($request->route()?->getName() ?? '', 'admin.')) {
            return 'admin'; // Esempio: se hai un layout admin.blade.php separato per le rotte admin
        }

        return parent::rootView($request);
    }

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    // TODO : questo ho messo solo per studiare javid
    public function share(Request $request): array
    {
        $user = $request->user();

        return array_merge(parent::share($request), [
            'auth' => $user ? [
                // Usiamo il tuo metodo toEntity() se restituisce i dati base dell'utente
                // o specifichiamo i campi manualmente.
                // Per ora, specifico i campi per chiarezza e aggiungo ruoli/permessi.
                'user' => [
                    'id' => $user->id, // Assumendo che l'ID sia disponibile
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames(), // Nomi dei ruoli ['admin', 'user']
                    'permissions' => $user->getAllPermissions()->pluck('name'), // Tutti i permessi ['edit articles', ...]
                ],
            ] : null,
            // TODO : poi guardo cosa sarebbe questo
            'ziggy' => function () use ($request) { // Se usi Ziggy
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => [ // Esempio per messaggi flash
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ]);
    }
    // TODO : Questo renderà auth.user.roles e auth.user.permissions disponibili globalmente nei tuoi componenti Vue di Inertia tramite $page.props.
}
