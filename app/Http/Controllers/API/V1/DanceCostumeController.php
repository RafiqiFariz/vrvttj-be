<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\DanceCostumesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\DanceCostumeRequest;
use App\Http\Resources\V1\DanceCostumeResource;
use App\Models\DanceCostume;
use App\Traits\RequestSourceHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DanceCostumeController extends Controller
{
    use RequestSourceHandler;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $this->authorizeRequest($request, 'dance_costume_access');

        $filter = new DanceCostumesFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);
        $includeDance = $request->query('includeDance');

        $danceCostumes = DanceCostume::where($filterItems);

        if ($includeDance) {
            $danceCostumes = $danceCostumes->with(['dance']);
        }

        if ($paginate == 'false' || $paginate == '0') {
            return DanceCostumeResource::collection($danceCostumes->get());
        }

        return DanceCostumeResource::collection($danceCostumes->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DanceCostumeRequest $request): JsonResponse
    {
        $danceCostume = DanceCostume::create($request->except(['picture', 'asset_path']));

        $filePicture = $request->file('picture');
        $fileName = uniqid() . "-" . Str::kebab($request->name) . '.' . $filePicture->getClientOriginalExtension();
        $picPath = $filePicture->storeAs('dance_costumes/pictures', $fileName, 'public');

        $assetName = $request->file('asset_path')->getClientOriginalName();
        $assetName = uniqid() . "-" . Str::snake($assetName);
        $assetPath = $request->file('asset_path')->storeAs('dance_costumes/assets', $assetName, 'public');

        $danceCostume->update([
            'picture' => $picPath,
            'asset_path' => $assetPath,
        ]);

        return response()->json([
            "message" => "Dance costume created successfully",
            "data" => new DanceCostumeResource($danceCostume),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(DanceCostume $danceCostume): DanceCostumeResource
    {
        $this->authorizeRequest(request(), 'dance_costume_show');
        return new DanceCostumeResource($danceCostume);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DanceCostumeRequest $request, DanceCostume $danceCostume): JsonResponse
    {
        $danceCostume->update($request->except(['picture', 'asset_path']));

        if ($request->hasFile('picture')) {
            $filePicture = $request->file('picture');
            $fileName = uniqid() . "-" . Str::kebab($request->name) . '.' . $filePicture->getClientOriginalExtension();
            $picPath = $filePicture->storeAs('dance_costumes/picture', $fileName, 'public');
            $danceCostume->update(['picture' => $picPath]);
        }

        if ($request->hasFile('asset_path')) {
            $assetPath = $request->file('asset_path')->store('dance_costumes/asset', 'public');
            $danceCostume->update(['asset_path' => $assetPath]);
        }

        return response()->json([
            "message" => "Dance costume $danceCostume->id updated successfully",
            "data" => new DanceCostumeResource($danceCostume),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DanceCostume $danceCostume): JsonResponse
    {
        $this->authorizeRequest(request(), 'dance_costume_delete');

        if ($danceCostume->picture) {
            Storage::disk('public')->delete($danceCostume->picture);
        }

        if ($danceCostume->asset_path) {
            Storage::disk('public')->delete($danceCostume->asset_path);
        }

        $danceCostume->delete();
        return response()->json([
            "message" => "Dance costume deleted successfully",
        ]);
    }
}
