<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ActiveColor;
use App\Models\Advised;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class ProductController extends Controller
{
    public function products($slug = null, $secondSlug=null, $thirdSlug=null){

/*


        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->has('sort_by')) {
            $sort_by = $request->sort_by;

            if ($sort_by === 'price_low_high') {
                $query->orderBy('price', 'asc');
            } else if ($sort_by === 'price_high_low') {
                $query->orderBy('price', 'desc');
            } else if ($sort_by === 'newest_first') {
                $query->orderBy('created_at', 'desc');
            } else if ($sort_by === 'oldest_first') {
                $query->orderBy('created_at', 'asc');
            }
        }*/


        $category = null;
        if(Request::input('category')){
            $category = Category::where('slug', Request::input('category'))->first();
        }
        if(Request::input('sub_category')){
            $category = SubCategory::where('slug', Request::input('sub_category'))->first();
        }
        if(Request::input('child_category')){
            $category = ChildCategory::where('slug', Request::input('child_category'))->first();
        }

        $categories = Category::with(['subCategories', 'subCategories.childCategories'])->get();
        $brands = Brand::all();

        $products = Product::query()
        ->with(['category','subCategory','childCategory', 'brand', 'user'])
        ->when(Request::input('category'), function ($query, $search) use($category){
            $query->whereHas('category', function ($query)use($search){
                $query->where('slug', $search);
            });
        })
        ->when(Request::input('sub_category'), function ($query, $search){
            $query->whereHas('subCategory', function ($query)use($search){
                $query->where('slug', $search);
            });
        })

        ->when(Request::input('child_category'), function ($query, $search){
            $query->whereHas('childCategory', function ($query)use($search){
                $query->where('slug', $search);
            });
        })
        ->when(Request::input('brand'), function ($query, $search){
            $query->whereHas('brand', function ($query)use($search){
                $query->where('slug', $search);
            });
        })
        ->when(Request::input('condition'), function ($query, $search){
            if($search == 'null'){
                $query->orderBy('cod', 'asc');
            }
            if($search == 'used'){
                $query->where('cod', 1);
            }
            if($search == 'new'){
                $query->where('cod', 0);
            }
        })
        ->when(Request::input('priceRange'), function ($query, $search){
            $query->whereBetween('price', [$search['min'], $search['max']]);
        })
        ->when(Request::input('orderBy'), function ($query, $search) {
            if ($search === 'price_low_high'){
                $query->orderBy('price', 'asc');
            }
            if ($search === 'price_high_low'){
                $query->orderBy('price', 'desc');
            }
            if ($search === 'newest_first'){
                $query->orderBy('created_at', 'desc');
            }
            if ($search === 'oldest_first'){
                $query->orderBy('created_at', 'asc');
            }
        })
        ->when(Request::input('search'), function ($query, $search){
            $query->where('title', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(Request::input('perPage') ?? 30)
        ->withQueryString()
        ->through(fn($product) => [
            'product' => $product
        ]);

        return inertia('Frontend/Product/Products',[
            'products' => $products,
            'category' => $category,
            'categories' => $categories,
            'brands' => $brands,
            'maxPrice' => Product::query()->max('price'),
            'minPrice' => Product::query()->min('price'),
            'filters' => Request::only(['search','perPage', 'dateRange']),
            'checkCondition' => Request::input(['condition']),
            'main_url' => URL::full(),
        ]);
    }


    public function adsProducts(){
        $add = Advised::where('slug', Request::input('add'))->first();
        $add->products = Product::whereIn('id', json_decode($add->products))->paginate(16);
        return inertia('Frontend/Product/AdsProducts',[
           'addInfo' => $add
        ]);

    }



    public function singleProduct($slug){

        $product = Product::with(['category', 'brand', 'brand.products', 'category.products'])->where('slug', $slug)->first();//->with(['category', 'brand', 'active_color', 'category.products'])->first();
//        $add = Advised::where('id', Request::input('add_id'))->first();

//        $discountData = null;
//        if (!empty($add)){
//            $array = array_map(function($item) use($product){
//                return intval($item);
//            }, json_decode($add->products));
//
//            if (in_array($product->id, $array)){
//                $discountData = $add;
//            }
//        }

//        $color = ActiveColor::findOrFail($product->active_color_id);


        return inertia("Frontend/Product/SingleProduct",[
            "product" => $product,
//            "color" => $color,
//            "discountData" => $discountData
        ]);
    }

    public function singleProductWithDiscount($slug){
        $product = Product::where('slug', $slug)->with(['category', 'brand', 'active_color', 'category.products'])->first();
        $color = ActiveColor::findOrFail($product->active_color_id);

        if (Request::input('discountType') !== null && Request::input('discountAmount')){
            return inertia("Frontend/Product/SingleProduct",[
                "product" => $product,
                "color" => $color,
                "discountType" => Request::input('discountType'),
                "discountAmount" => Request::input('discountAmount'),
            ]);
        }

        return redirect()->back()->withErrors(['message' => 'Discount Type Or Discount Amount Not Found.']);
    }


    public function latestOffers(){
        $add = Advised::query()->latest()->paginate(12);

        return inertia('Frontend/Product/AllAds',[
            'adds' => $add
        ]);
    }


}

