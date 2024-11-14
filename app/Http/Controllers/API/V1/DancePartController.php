<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\DancePartsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\DancePartRequest;
use App\Http\Resources\V1\DancePartResource;
use App\Models\DancePart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DancePartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        abort_if(Gate::denies('dance_part_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $filter = new DancePartsFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);

        $danceParts = DancePart::where($filterItems);

        if ($paginate == 'false' || $paginate == '0') {
            return DancePartResource::collection($danceParts->get());
        }

        return DancePartResource::collection($danceParts->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DancePartRequest $request): JsonResponse
    {
        $dancePart = DancePart::create($request->except('picture'));

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('dance_parts', 'public');
            $dancePart->update(['picture' => $path]);
        }

        return response()->json([
            "message" => "Dance part created successfully",
            "data" => new DancePartResource($dancePart),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(DancePart $dancePart): DancePartResource
    {
        return new DancePartResource($dancePart);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DancePartRequest $request, DancePart $dancePart): JsonResponse
    {
        $dancePart->update($request->except('picture'));

        if ($request->hasFile('picture')) {
            if ($dancePart->picture) {
                Storage::disk('public')->delete($dancePart->picture);
            }
            $path = $request->file('picture')->store('dance_parts', 'public');
            $dancePart->update(['picture' => $path]);
        }

        return response()->json([
            "message" => "Dance part updated successfully",
            "data" => new DancePartResource($dancePart),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DancePart $dancePart): JsonResponse
    {
        abort_if(Gate::denies('dance_part_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');

        if ($dancePart->danceMoves()->exists()) {
            return response()->json([
                "message" => "Dance part cannot be deleted because it has dance moves",
            ], Response::HTTP_CONFLICT);
        }

        if ($dancePart->picture) {
            Storage::disk('public')->delete($dancePart->picture);
        }

        $dancePart->delete();
        return response()->json([
            "message" => "Dance part deleted successfully",
        ]);
    }
}
