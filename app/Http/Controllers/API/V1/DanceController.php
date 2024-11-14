<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\DancesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\DanceRequest;
use App\Http\Resources\V1\DanceResource;
use App\Models\Dance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        abort_if(Gate::denies('dance_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $filter = new DancesFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);

        $dances = Dance::where($filterItems);

        if ($paginate == 'false' || $paginate == '0') {
            return DanceResource::collection($dances->get());
        }

        return DanceResource::collection($dances->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DanceRequest $request): JsonResponse
    {
        $dance = Dance::create($request->except('picture'));

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('dances', 'public');
            $dance->update(['picture' => $path]);
        }

        return response()->json([
            "message" => "Dance created successfully",
            "data" => new DanceResource($dance),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dance $dance): DanceResource
    {
        return new DanceResource($dance);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dance $dance): JsonResponse
    {
        $dance->update($request->except('picture'));

        if ($request->hasFile('picture')) {
            if ($dance->picture) {
                Storage::disk('public')->delete($dance->picture);
            }
            $path = $request->file('picture')->store('dances', 'public');
            $dance->update(['picture' => $path]);
        }

        return response()->json([
            "message" => "Dance created successfully",
            "data" => new DanceResource($dance),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dance $dance): JsonResponse
    {
        abort_if(Gate::denies('dance_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');

        if ($dance->danceMoves()->exists()) {
            return response()->json([
                "message" => "Dance cannot be deleted because it has dance moves",
            ], Response::HTTP_CONFLICT);
        }

        if ($dance->picture) {
            Storage::disk('public')->delete($dance->picture);
        }

        $dance->delete();
        return response()->json([
            "message" => "Dance deleted successfully",
        ]);
    }
}
