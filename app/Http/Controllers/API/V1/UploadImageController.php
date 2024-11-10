<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadImageController extends Controller
{
    public function upload(Request $request)
    {
        $isTemp = is_string($request->photo) && str_starts_with($request->photo, 'storage/tmp');

        if ($isTemp) {
            $photoName = explode('/', $request->photo)[2];
            $photoName = explode('?', $photoName)[0];
            $file = new File(storage_path("app/private/tmp/$photoName"));
            $photoPath = Storage::disk('public')->putFile("images", $file);
            Storage::delete("tmp/$photoName");

            return $photoPath;
        }

        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);

        $tempPath = "";

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $tempPath = $photo->storeAs("tmp", $photoName);
        }

        return Storage::temporaryUrl($tempPath, now()->addMinutes(10));
    }
}
