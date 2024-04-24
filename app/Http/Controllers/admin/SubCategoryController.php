<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $subCategory = SubCategory::select('sub_categories.*', 'categories.name as categoryName')
            ->latest('sub_categories.id')
            ->leftJoin('categories', 'categories.id', 'sub_categories.category_id');

        if (!empty($request->get('keyword'))) {
            $subCategory = $subCategory->where('sub_categories.name', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('categories.name', 'like', '%' . $request->get('keyword') . '%');
        }
        $subCategory = $subCategory->paginate(10);
        return view('admin.sub_category.list', compact('subCategory'));
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('admin.sub_category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
            'category' => 'required',
            'status' => 'required',
        ]);
        if ($validator->passes()) {
            $subCategory = new SubCategory();
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->showHome = $request->showHome;
            $subCategory->category_id = $request->category;
            $subCategory->save();
            session()->flash('success', 'Sub Category saved successfully');
            return response()->json([
                'status' => true,
                'message' => 'SubCategory saved successfully'
            ]);
        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function edit(Request $request, $subCategoryId)
    {
        $subCategory = SubCategory::find($subCategoryId);
        $categories = Category::orderBy('name', 'ASC')->get();
        if (empty($subCategory)) {
            session()->flash('error', 'Record Not Found');
            return redirect()->route('sub_categories.index');
        }
        return view('admin.sub_category.edit', compact('subCategory', 'categories'));
    }

    public function update(Request $request, $subCategoryId)
    {
        $subCategory = SubCategory::find($subCategoryId);
        if (empty($subCategory)) {
            session()->flash('error', 'Sub Category Not Found');
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Sub Category not found',
            ]);
        };
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug,' . $subCategory->id . ',id',
            'category' => 'required',
            'status' => 'required',
        ]);
        if ($validator->passes()) {
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->showHome = $request->showHome;
            $subCategory->category_id = $request->category;
            $subCategory->save();
            session()->flash('success', 'Sub Category Update Successfully');
            return response()->json([
                'status' => true,
                'message' => 'Sub Category Updated Successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function destroy(Request $request, $categoryId)
    {
        $subCategory = SubCategory::find($categoryId);
        if (empty($subCategory)) {
            session()->flash('error', 'Sub Category Not Found');
            return response()->json([
                'status' => 'error',
                'message' => 'Sub Category Not Found',
            ]);
        }
        $subCategory->delete();

        session()->flash('success', 'Sub Category deleted successfully');
        return response()->json([
            'status' => 'success',
            'message' => 'Sub Category deleted successfully',
        ]);
    }
}
