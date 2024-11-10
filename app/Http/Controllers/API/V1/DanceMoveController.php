<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\DanceMovesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\DanceMoveRequest;
use App\Http\Resources\V1\DanceMoveCollection;
use App\Models\DanceMove;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DanceMoveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): DanceMoveCollection
    {
        abort_if(Gate::denies('dance_move_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

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
            return new DanceMoveCollection($danceMoves->get());
        }

        return new DanceMoveCollection($danceMoves->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DanceMoveRequest $request): \Illuminate\Http\JsonResponse
    {
        $danceMove = DanceMove::create($request->except('picture'));

        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('dance_moves', 'public');
            $danceMove->update(['picture' => $picturePath]);
        }

        return response()->json([
            "message" => "Dance move created successfully",
            "data" => $danceMove,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(DanceMove $danceMove): DanceMoveCollection
    {
        return new DanceMoveCollection($danceMove->load(['danceType', 'dancePart']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DanceMoveRequest $request, DanceMove $danceMove): \Illuminate\Http\JsonResponse
    {
        $danceMove->update($request->except('picture'));

        if ($request->hasFile('picture')) {
            Storage::disk('public')->delete($danceMove->picture);
            $picturePath = $request->file('picture')->store('dance_moves', 'public');
            $danceMove->update(['picture' => $picturePath]);
        }

        return response()->json([
            "message" => "Dance move updated successfully",
            "data" => $danceMove,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DanceMove $danceMove): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('dance_move_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');

        if ($danceMove->picture) {
            Storage::disk('public')->delete($danceMove->picture);
        }

        $danceMove->delete();
        return response()->json([
            "message" => "Dance move deleted successfully",
        ]);
    }
}
