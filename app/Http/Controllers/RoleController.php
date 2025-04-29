<?php

namespace App\Http\Controllers;

use App\Constant\TableParametersConst\AuthConst\UserJson;
use App\Constant\TableParametersConst\RoleJson;
use App\Domain\Controllers\Controller;
use App\Domain\Services\RoleServiceContract;
use App\Http\Requests\Role\RolePostRequest;
use Illuminate\Http\JsonResponse;
use PHPUnit\Event\Code\Throwable;

class RoleController extends Controller
{
    public function __construct(protected ?RoleServiceContract $roleService = null)
    {
        $this->roleService ??= app(RoleServiceContract::class);
    }

    public function create(RolePostRequest $request): JsonResponse
    {
        try {
            $request->validated()
                ? $this->roleService->create($request->validated())
                : throw new \InvalidArgumentException('Invalid data');

            return response()->json([
                RoleJson::MESSAGE => 'Role created successfully'
            ]);
        } catch (\Throwable $throwable) {
            return response()->json([
                RoleJson::MESSAGE => $throwable->getMessage()
            ], 422);
        }
    }
}
