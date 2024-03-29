<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug = null, $subCategorySlug = null)
    {
        $categorySelected = '';
        $subCategorySelected = '';
        $brandsArray = [];

        $categories = Category::orderBy('name', 'ASC')->with('sub_category')->where('status', 1)->get();
        $brands = Brand::orderBy('name', 'ASC')->where('status', 1)->get();

        $products = Product::where('status', 1);
        //filter
        if (!empty($categorySlug)) {
            $category = Category::where('slug', $categorySlug)->first();
            $products = $products->where('category_id', $category->id);
            $categorySelected = $category->id;
        }
        if (!empty($subCategorySlug)) {
            $subcategory = SubCategory::where('slug', $subCategorySlug)->first();
            $products = $products->where('sub_category_id', $subcategory->id);
            $subCategorySelected = $subcategory->id;
        }
        if (!empty($request->get('brand'))) {
            $brandsArray = explode(',', $request->get('brand'));
            $products = $products->whereIn('brand_id', $brandsArray);
        }
        if ($request->get('price_min') != '' && $request->get('price_max') != '') {
            if ($request->get('price_max')) {
                $products = $products->whereBetween('price', [$request->get('price_min'), 1000000]);
            } else {
                $products = $products->whereBetween('price', [$request->get('price_min'), $request->get('price_max')]);
            }
        }

        if ($request->get('sort') != '') {
            if ($request->get('sort') == 'latest') {
                $products = $products->orderBy('id', 'DESC');
            } else if ($request->get('sort') == 'price_asc') {
                $products = $products->orderBy('price', 'ASC');
            } else {
                $products = $products->orderBy('price', 'DESC');
            }
        } else {
            $products = $products->orderBy('id', 'DESC');
        }

        $products = $products->paginate(6);

        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['products'] = $products;
        $data['categorySelected'] = $categorySelected;
        $data['subCategorySelected'] = $subCategorySelected;
        $data['brandsArray'] = $brandsArray;
        $data['priceMin'] = intval($request->get('price_min'));
        $data['priceMax'] = (intval($request->get('price_max')) == 0) ? 1000000 : intval($request->get('price_max'));
        $data['sort'] = $request->get('sort');
        return view('front.shop', $data);
    }
    public function product($slug)
    {
        $product = Product::where('slug', $slug)->with('product_images')->first();
        // dd($product);
        if ($product == null) {
            abort(404);
        }
        //fetch related products
        $relatedProducts = [];
        if ($product->related_products != '') {
            $productArray = explode(',', $product->related_products);
            $relatedProducts = Product::whereIn('id', $productArray)->with('product_images')->get();
        }
        $data['product'] = $product;
        $data['relatedProducts'] = $relatedProducts;
        return view('front.product', $data);
    }
}
