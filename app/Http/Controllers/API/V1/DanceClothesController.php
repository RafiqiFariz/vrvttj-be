<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\DanceClothsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\DanceClothesRequest;
use App\Http\Resources\V1\DanceClothesCollection;
use App\Http\Resources\V1\DanceClothesResource;
use App\Models\DanceClothes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class DanceClothesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): DanceClothesCollection
    {
        abort_if(Gate::denies('dance_cloth_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $filter = new DanceClothsFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);
        $includeDance = $request->query('includeDance');

        $danceClothes = DanceClothes::where($filterItems);

        if ($paginate == 'false' || $paginate == '0') {
            return new DanceClothesCollection($danceClothes->get());
        }

        if ($includeDance) {
            $danceClothes = $danceClothes->with(['dance']);
        }

        return new DanceClothesCollection($danceClothes->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DanceClothesRequest $request): \Illuminate\Http\JsonResponse
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
        return new DanceClothesResource($danceCloth);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DanceClothesRequest $request, DanceClothes $danceCloth): \Illuminate\Http\JsonResponse
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
    public function destroy(DanceClothes $danceCloth): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('dance_cloth_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');

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
