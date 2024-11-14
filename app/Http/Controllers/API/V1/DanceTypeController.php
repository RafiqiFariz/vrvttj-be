<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\DanceTypesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\DanceTypeRequest;
use App\Http\Resources\V1\DanceTypeResource;
use App\Models\DanceType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class DanceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        abort_if(Gate::denies('dance_type_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $filter = new DanceTypesFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);

        $danceTypes = DanceType::where($filterItems);

        if ($paginate == 'false' || $paginate == '0') {
            return DanceTypeResource::collection($danceTypes->get());
        }

        return DanceTypeResource::collection($danceTypes->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DanceTypeRequest $request): JsonResponse
    {
        $danceType = DanceType::create($request->all());
        return response()->json([
            "message" => "Dance type created successfully",
            "data" => new DanceTypeResource($danceType),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(DanceType $danceType): DanceTypeResource
    {
        return new DanceTypeResource($danceType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DanceTypeRequest $request, DanceType $danceType): JsonResponse
    {
        $danceType->update($request->all());
        return response()->json([
            "message" => "Dance type updated successfully",
            "data" => new DanceTypeResource($danceType),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DanceType $danceType): JsonResponse
    {
        abort_if(Gate::denies('dance_type_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $danceType->delete();
        return response()->json([
            "message" => "Dance type deleted successfully",
        ]);
    }
}
