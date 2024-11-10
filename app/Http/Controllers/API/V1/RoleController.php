<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RoleRequest;
use App\Http\Resources\V1\RoleCollection;
use App\Http\Resources\V1\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): RoleCollection
    {
        $includePermissions = $request->query('includePermissions');

        $roles = Role::query();

        if ($includePermissions) {
            $roles = $roles->with(['permissions']);
        }

        return new RoleCollection($roles->paginate(20)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(RoleRequest $request): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();
        try {
            $role = Role::create($request->only('name'));
            $role->permissions()->sync($request->input('permissions', []));

            DB::commit();
            return response()->json([
                "message" => "Role created successfully",
                "data" => new RoleResource($role),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): RoleResource
    {
        $includePermissions = request()->query('includePermissions');

        if ($includePermissions) {
            return new RoleResource($role->loadMissing('permissions'));
        }

        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(RoleRequest $request, Role $role): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();
        try {
            $role->update($request->only('name'));
            $role->permissions()->sync($request->input('permissions', []));

            DB::commit();
            return response()->json([
                "message" => "Role $role->id updated successfully",
                "data" => new RoleResource($role)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): \Illuminate\Http\JsonResponse
    {
        $role->delete();
        return response()->json(["message" => "Role deleted successfully"]);
    }
}
