<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Properties;
use App\Models\ActiveColor;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class ProductController extends Controller
{
   public function index(){
       return inertia('Products/Index', [
           'products' => Product::query()
               ->with(['category','brand', 'user'])
               ->when(Request::input('search'), function ($query, $search) {
                   $query->where('title', 'like', "%{$search}%");
               })
               ->latest()
               ->paginate(Request::input('perPage') ?? 20)
               ->withQueryString()
               ->through(fn($product) => [
                   'id' => $product->id,
                   'title' => $product->title,
                   'slug' => $product->slug,
                   'price' => $product->price,
                   'description' => $product->description,
                   'featured' => $product->featured,
                   'category' => $product->category,
                   'thumbnail' =>$product->thumbnail,
               ]),
           'filters' => Request::only(['search','perPage', 'dateRange']),
           'main_url' => URL::route('admin.product.index')
       ]);


   }

   public function create(){

       $categories = Category::with('subCategories', 'subCategories.childCategories')->get();
       $brands = Brand::all();
    //    $colors = ActiveColor::orderby('name', 'asc')->get();

       return inertia('Products/Create', [
           'categories' => $categories,
           'brands' => $brands,
        //    'colors' => $colors,
           'save_url' => URL::route('admin.product.store')
       ]);
   }

   public function store(){
       Request::validate([
           'productTitle' => 'required',
           'categoryId' => 'required',
//           'brandId' => 'required',
           'productPrice' => 'required',
           'unit' => 'required',
           'qty' => 'required',
           'description' => 'nullable|min:100'
       ]);

//       if (Request::input('discountAmount') != null){
//           Request::validate([
//               'discountType' => 'required'
//           ]);
//       }

       if (Request::input('shippingType') === 'p'){
           Request::validate([
               'inSideDhaka' => 'required',
               'outSideDhaka' => 'required',
           ]);
       }

       if (Request::hasFile('thumbnail')){
           $icon = Request::file('thumbnail')->store('uploads/all', 'public');
//           fileResize(Request::file('thumbnail'), $icon, Properties::$productImageWeight, Properties::$productImageHeight);
           $data['thumbnail'] = $icon;
       }

       $images = [];
       if (Request::file('images')){
           foreach (Request::file('images') as $img){
               $path = $img->store('uploads/all', 'public');
//               fileResize($img, $path, 200, 300);
               $images[] = $path;
           }
       }


       $data['sku'] = Request::input('productId');
       $data['title'] = Request::input('productTitle');
       $data['user_id'] = Auth::id();
       $data['category_id'] = Request::input('categoryId');
       $data['sub_category_id'] = Request::input('subCategoryId');
       $data['child_category_id'] = Request::input('childCategoryId');

       $data['brand_id'] = Request::input('brandId') ? intval(Request::input('brandId')["id"]) : null;
       $data['active_color_id'] = Request::input('colorId') ? intval(Request::input('colorId')["id"]) : null;

       $data['price'] = intval(Request::input('productPrice'));
       $data['discount'] = intval(Request::input('discountAmount'));
       $data['discount_type'] = Request::input('discountType');
       $data['unit'] = Request::input('unit');
       $data['qty'] = intval(Request::input('qty'));
       $data['low_stoke_qty'] = intval(Request::input('low_stoke_qty'));
       $data['images'] = json_encode($images);
       $data['sizes'] = json_encode(Request::input('sizes'));
       $data['description'] = Request::input('description');
       $data['specification'] = Request::input('specification');
       $data['shipping_type'] = Request::input('shippingType');
       $data['inside_in_dhaka'] = intval(Request::input('inSideDhaka'));
       $data['outside_in_dhaka'] = intval(Request::input('outSideDhaka'));
       $data['cod'] = (int)Request::input('cod');
       $data['tax'] = Request::input('tax');
       $data['tax_type'] = Request::input('taxType');
       $data['vat'] = Request::input('vat');
       $data['vat_type'] = Request::input('vatType');

//       return $data;


       Product::create($data);
       return back();

   }

   public function edit($slug)
   {
       $categories = Category::with('childrens')->get();
       $brands = Brand::all();
//       $colors = ActiveColor::orderby('name', 'asc')->get();
       return inertia('Products/Edit', [
           'product' =>  Product::where('slug', $slug)->first(),
           'categories' => $categories,
           'brands' => $brands,
//           'colors' => $colors,
           'update_url' => URL::route('admin.product.update', $slug)
       ]);
   }


   public function update($slug){
       $product = Product::where('slug', $slug)->first();



       if (Request::hasFile('thumbnail')){
           $icon = Request::file('thumbnail')->store('uploads/all', 'public');
//           fileResize(Request::file('thumbnail'), $icon, Properties::$productImageWeight, Properties::$productImageHeight);
           $product->thumbnail = $icon;
       }

       $images = Request::input('images');
       if (Request::file('images')) {
           foreach (Request::file('images') as $img) {
               $path = $img->store('uploads/all', 'public');
//               fileResize($img, $path, 200, 300);
               $images[] = $path;
           }
       }

       $product->images = json_encode($images);



       $product->sku = Request::input('productId');
       $product->title = Request::input('productTitle');
       $product->user_id = Auth::id();
       $product->category_id = Request::input('categoryId') ? intval(Request::input('categoryId')) : null;
       $product->brand_id = Request::input('brandId') ? intval(Request::input('brandId')) : null;
       $product->active_color_id = Request::input('colorId') ? intval(Request::input('colorId')) : null;

       $product->price = intval(Request::input('productPrice'));
       $product->discount = intval(Request::input('discountAmount'));
       $product->discount_type = Request::input('discountType');
       $product->unit = Request::input('unit');
       $product->qty = intval(Request::input('qty'));
       $product->low_stoke_qty = intval(Request::input('lowStokeQty'));
       $product->sizes = json_encode(Request::input('sizes'));
       $product->description = Request::input('description');
       $product->cod = (int)Request::input('cod');

       $product->specification = Request::input('specification');
       $product->shipping_type = Request::input('shippingType');

       $product->update();
       return redirect()->route('admin.product.index')->with('message', 'Your Product Updated...');
   }



    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
   public function destroy($id){

       $product = Product::findOrFail($id);
        $product->delete();
        return back();
   }

}
