<?php

namespace App\Http\Controllers;

use App\Domain\Controllers\Controller;
use App\Domain\Services\RoleServiceContract;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{
    public function __construct(protected ?RoleServiceContract $roleService = null)
    {
        $this->roleService ??= app(RoleServiceContract::class);
    }

    public function index(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'user' => auth()->user()->load('roles', 'permissions'),
        ]);
    }
}
