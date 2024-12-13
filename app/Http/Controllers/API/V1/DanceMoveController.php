<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\DanceMovesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\DanceMoveRequest;
use App\Http\Resources\V1\DanceMoveResource;
use App\Models\DanceMove;
use App\Traits\RequestSourceHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class DanceMoveController extends Controller
{
    use RequestSourceHandler;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $this->authorizeRequest($request, 'dance_move_access');

        $filter = new DanceMovesFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $includeDance = $request->query('includeDance');
        $includeDancePart = $request->query('includeDancePart');

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);

        $danceMoves = DanceMove::where($filterItems);

        if ($includeDance) {
            $danceMoves = $danceMoves->with(['dance']);
        }

        if ($includeDancePart) {
            $danceMoves = $danceMoves->with(['dancePart']);
        }

        if ($paginate == 'false' || $paginate == '0') {
            return DanceMoveResource::collection($danceMoves->get());
        }

        return DanceMoveResource::collection($danceMoves->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DanceMoveRequest $request): JsonResponse
    {
        $danceMove = DanceMove::create($request->except('picture'));

        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('dance_moves', 'public');
            $danceMove->update(['picture' => $picturePath]);
        }

        return response()->json([
            "message" => "Dance move created successfully",
            "data" => new DanceMoveResource($danceMove),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(DanceMove $danceMove): DanceMoveResource
    {
        $this->authorizeRequest(request(), 'dance_move_show');
        return new DanceMoveResource($danceMove->load(['danceType', 'dancePart']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DanceMoveRequest $request, DanceMove $danceMove): JsonResponse
    {
        $danceMove->update($request->except('picture'));

        if ($request->hasFile('picture')) {
            Storage::disk('public')->delete($danceMove->picture);
            $picturePath = $request->file('picture')->store('dance_moves', 'public');
            $danceMove->update(['picture' => $picturePath]);
        }

        return response()->json([
            "message" => "Dance move updated successfully",
            "data" => new DanceMoveResource($danceMove),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DanceMove $danceMove): JsonResponse
    {
        $this->authorizeRequest(request(), 'dance_move_delete');

        if ($danceMove->picture) {
            Storage::disk('public')->delete($danceMove->picture);
        }

        $danceMove->delete();
        return response()->json([
            "message" => "Dance move deleted successfully",
        ]);
    }
}
