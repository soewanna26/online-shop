<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductImageController extends Controller
{
    public function update(Request $request)
    {
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $tempImageLocation = $image->getPathName();

        $productImage = new ProductImage();
        $productImage->product_id = $request->product_id;
        $productImage->image = 'NULL';
        $productImage->save();

        $imageName = $request->product_id . "-" . $productImage->id . "-" . time() . "." . $ext;
        $productImage->image = $imageName;
        $productImage->save();

        //large images
        $manager = new ImageManager(new Driver());
        $destPath = public_path() . '/uploads/product/large/' . $imageName;
        $image = $manager->read($tempImageLocation);
        $image->resize(1400, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save($destPath);
        //small images
        $destPath = public_path() . '/uploads/product/small/' . $imageName;
        $image->resize(300, 300);
        $image->save($destPath);

        return response()->json([
            'status' => true,
            'image_id' => $productImage->id,
            'ImagePath' => asset('uploads/product/small/' . $productImage->image),
            'message' => 'Image save successfully',
        ]);
    }

    public function destroy(Request $request)
    {
        $productImage = ProductImage::find($request->id);
        if(empty($productImage))
        {
            return response()->json([
                'status' => false,
                'message' => 'Image not found',
            ]);
        }
        //Delete Image from folder
        File::delete(public_path('uploads/product/large/' . $productImage->image));
        File::delete(public_path('uploads/product/small/' . $productImage->image));
        $productImage->delete();
        return response()->json([
            'status' => true,
            'message' => 'Image delete successfully',
        ]);
    }
}
