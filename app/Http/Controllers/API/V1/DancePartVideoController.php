<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\DancePartVideoRequest;
use App\Http\Resources\V1\DancePartVideoResource;
use App\Models\DancePart;
use App\Models\DancePartVideo;
use App\Traits\RequestSourceHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DancePartVideoController extends Controller
{
    use RequestSourceHandler;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DancePart $dancePart)
    {
        $this->authorizeRequest($request, 'dance_part_video_access');

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);

        $dancePartVideos = $dancePart->dancePartVideos();

        if ($paginate == 'false' || $paginate == '0') {
            return DancePartVideoResource::collection($dancePartVideos->get());
        }

        return DancePartVideoResource::collection($dancePartVideos->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Display the specified resource.
     */
    public function show(DancePart $dancePart, DancePartVideo $dancePartVideo): \Illuminate\Http\JsonResponse
    {
        $this->authorizeRequest(request(), 'dance_part_video_show');

        return response()->json([
            'data' => new DancePartVideoResource($dancePartVideo),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DancePartVideoRequest $request, DancePart $dancePart): \Illuminate\Http\JsonResponse
    {
        $this->authorizeRequest($request, 'dance_part_video_create');

        $thumbnailPath = $request->file('thumbnail_path')->store('dance_parts/thumbnails', 'public');
        $videoPath = $request->file('video_path')->store('dance_parts/videos', 'public');

        $dancePartVideo = $dancePart->dancePartVideos()->create([
            'thumbnail_path' => $thumbnailPath,
            'video_path' => $videoPath,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Dance part video created successfully',
            'data' => new DancePartVideoResource($dancePartVideo),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DancePartVideoRequest $request, DancePart $dancePart, DancePartVideo $dancePartVideo): \Illuminate\Http\JsonResponse
    {
        $this->authorizeRequest($request, 'dance_part_video_update');

        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($dancePartVideo->thumbnail_path);
            $thumbnailPath = $request->file('thumbnail')->store('dance_parts/thumbnails', 'public');
            $dancePartVideo->thumbnail_path = $thumbnailPath;
        }

        if ($request->hasFile('video')) {
            Storage::disk('public')->delete($dancePartVideo->video_path);
            $videoPath = $request->file('video')->store('dance_parts/videos', 'public');
            $dancePartVideo->video_path = $videoPath;
        }

        $dancePartVideo->description = $request->description;
        $dancePartVideo->save();

        return response()->json([
            'message' => 'Dance part video updated successfully',
            'data' => new DancePartVideoResource($dancePartVideo),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DancePart $dancePart, DancePartVideo $dancePartVideo): \Illuminate\Http\JsonResponse
    {
        $this->authorizeRequest(request(), 'dance_part_video_delete');

        Storage::disk('public')->delete([$dancePartVideo->thumbnail_path, $dancePartVideo->video_path]);
        $dancePartVideo->delete();

        return response()->json(['message' => 'Dance part video deleted successfully']);
    }
}
