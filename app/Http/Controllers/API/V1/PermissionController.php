<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\PermissionRequest;
use App\Http\Resources\V1\PermissionResource;
use App\Models\Permission;
use App\Traits\RequestSourceHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    use RequestSourceHandler;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $this->authorizeRequest($request, 'permission_access');

        $pageSize = $request->query('pageSize', 20);
        return PermissionResource::collection(Permission::paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request): \Illuminate\Http\JsonResponse
    {
        $permission = Permission::create($request->all());
        return response()->json([
            "message" => "Permission created successfully",
            "data" => new PermissionResource($permission),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission): PermissionResource
    {
        $this->authorizeRequest(request(), 'permission_show');
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
            "data" => new PermissionResource($permission),
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
