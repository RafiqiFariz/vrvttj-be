<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\PermissionRequest;
use App\Http\Resources\V1\PermissionCollection;
use App\Http\Resources\V1\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): PermissionCollection
    {
        abort_if(Gate::denies('permission_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $pageSize = $request->query('pageSize', 20);
        return new PermissionCollection(Permission::paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request): \Illuminate\Http\JsonResponse
    {
        $permission = Permission::create($request->all());
        return response()->json([
            "message" => "Permission created successfully",
            "data" => $permission,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission): PermissionResource
    {
        abort_if(Gate::denies('permission_show'), Response::HTTP_FORBIDDEN, 'Forbidden');
        return new PermissionResource($permission);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, Permission $permission): \Illuminate\Http\JsonResponse
    {
        $permission->update($request->all());
        return response()->json([
            "message" => "Permission $permission->id updated successfully",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $permission->delete();
        return response()->json([
            "message" => "Permission deleted successfully",
        ]);
    }
}
