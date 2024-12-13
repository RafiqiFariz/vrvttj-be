<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\DanceClothsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\DanceClothesRequest;
use App\Http\Resources\V1\DanceClothesResource;
use App\Models\DanceClothes;
use App\Traits\RequestSourceHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DanceClothesController extends Controller
{
    use RequestSourceHandler;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $this->authorizeRequest($request, 'dance_cloth_access');

        $filter = new DanceClothsFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);
        $includeDance = $request->query('includeDance');

        $danceClothes = DanceClothes::where($filterItems);

        if ($includeDance) {
            $danceClothes = $danceClothes->with(['dance']);
        }

        if ($paginate == 'false' || $paginate == '0') {
            return DanceClothesResource::collection($danceClothes->get());
        }

        return DanceClothesResource::collection($danceClothes->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DanceClothesRequest $request): JsonResponse
    {
        $danceCloth = DanceClothes::create($request->except(['picture', 'asset_path']));

        $filePicture = $request->file('picture');
        $fileName = uniqid() . "-" . Str::kebab($request->name) . '.' . $filePicture->getClientOriginalExtension();
        $picPath = $filePicture->storeAs('dance_cloths/pictures', $fileName, 'public');

        $assetPath = $request->file('asset_path')->store('dance_cloths/assets', 'public');

        $danceCloth->update([
            'picture' => $picPath,
            'asset_path' => $assetPath,
        ]);

        return response()->json([
            "message" => "Dance cloth created successfully",
            "data" => new DanceClothesResource($danceCloth),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(DanceClothes $danceCloth): DanceClothesResource
    {
        $this->authorizeRequest(request(), 'dance_cloth_show');
        return new DanceClothesResource($danceCloth);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DanceClothesRequest $request, DanceClothes $danceCloth): JsonResponse
    {
        $danceCloth->update($request->except(['picture', 'asset_path']));

        if ($request->hasFile('picture')) {
            $filePicture = $request->file('picture');
            $fileName = uniqid() . "-" . Str::kebab($request->name) . '.' . $filePicture->getClientOriginalExtension();
            $picPath = $filePicture->storeAs('dance_cloths/picture', $fileName, 'public');
            $danceCloth->update(['picture' => $picPath]);
        }

        if ($request->hasFile('asset_path')) {
            $assetPath = $request->file('asset_path')->store('dance_cloths/asset', 'public');
            $danceCloth->update(['asset_path' => $assetPath]);
        }

        return response()->json([
            "message" => "Dance cloth $danceCloth->id updated successfully",
            "data" => new DanceClothesResource($danceCloth),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DanceClothes $danceCloth): JsonResponse
    {
        $this->authorizeRequest(request(),'dance_cloth_delete');

        if ($danceCloth->picture) {
            Storage::disk('public')->delete($danceCloth->picture);
        }

        if ($danceCloth->asset_path) {
            Storage::disk('public')->delete($danceCloth->asset_path);
        }

        $danceCloth->delete();
        return response()->json([
            "message" => "Dance cloth deleted successfully",
        ]);
    }
}
