<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TempImagesController extends Controller
{
    public function create(Request $request)
    {
        if ($request->image) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $newName = time() . '.' . $ext;

            $tempImage = new TempImage();
            $tempImage->name = $newName;
            $tempImage->save();

            $image->move(public_path() . '/temp/', $newName);

            // generate thumb
            $manager = new ImageManager(new Driver());

            // Set the source and destination paths
            $destPath = public_path() . '/temp/thumb/' . $newName;
            $image = $manager->read(public_path() . '/temp/' . $newName);
            $image->resize(300, 274);
            $image->save($destPath);

            return response()->json([
                'status' => true,
                'image_id' => $tempImage->id,
                'ImagePath' => asset('/temp/thumb/' . $newName),
                'message' => 'Image Upload Successfully'
            ]);
        }
    }
}
