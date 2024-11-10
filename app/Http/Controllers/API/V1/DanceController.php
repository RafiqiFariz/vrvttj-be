<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\DancesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\DanceRequest;
use App\Http\Resources\V1\DanceCollection;
use App\Http\Resources\V1\DanceResource;
use App\Models\Dance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): DanceCollection
    {
        abort_if(Gate::denies('dance_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $filter = new DancesFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);

        $danceParts = Dance::where($filterItems);

        if ($paginate == 'false' || $paginate == '0') {
            return new DanceCollection($danceParts->get());
        }

        return new DanceCollection($danceParts->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DanceRequest $request)
    {
        $dancePart = Dance::create($request->except('picture'));

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('dances', 'public');
            $dancePart->update(['picture' => $path]);
        }

        return response()->json([
            "message" => "Dance created successfully",
            "data" => $dancePart,
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
    public function update(Request $request, Dance $dance): \Illuminate\Http\JsonResponse
    {
        $dancePart = Dance::create($request->except('picture'));

        if ($request->hasFile('picture')) {
            if ($dancePart->picture) {
                Storage::disk('public')->delete($dancePart->picture);
            }
            $path = $request->file('picture')->store('dances', 'public');
            $dancePart->update(['picture' => $path]);
        }

        return response()->json([
            "message" => "Dance created successfully",
            "data" => $dancePart,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dance $dance): \Illuminate\Http\JsonResponse
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
