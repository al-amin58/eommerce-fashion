<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Advised;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class AdvisedController extends Controller
{
    public function allAdvisedIndex(){

        return inertia('Advised/Index', [
            'advised' => Advised::paginate(10),
            'main_url' => URL::route('admin.advisedIndex')
        ]);
    }

    public function advisedIndex(){
        return inertia('Advised/Create', [
            'products' => Product::with(['category:id,title', 'brand:id,name'])->get(),
        ]);
    }


    public function advisedEdit($id){
        $ads = Advised::findOrFail($id);

//        $products = [];
//        if ($ads->products !== "null"){
//            $products = Product::whereIn('id', json_decode($ads->products))->get();
//        }

        $products = array_map(function($item){
            return intval($item);
        }, json_decode($ads->products));

        return inertia('Advised/Create', [
           'data' => $ads,
           'selectedProduct' => $products,
           'products' => Product::with(['category:id,title', 'brand:id,name'])->get(),
        ]);

    }


    public function uploadAds(Request $request){

        Validator::validate($request->all(), [
           'title' => 'required',
           'imageFile' => 'required',
        ]);
        $data=$request->all();
        if($request->hasFile('imageFile')){
            $icon = $request->file('imageFile')->store('uploads/all', 'public');
            $data['image'] = $icon;
        }
        $data['products'] = json_encode($request->input('products'));
        Advised::create($data);
        return back();
    }

    public function updateAds(Request $request, $id){
        $ads = Advised::findOrFail($id);
        $data = $request->all();
        if(Request::hasFile('imageFile')){
            $icon = $request->file('imageFile')->store('uploads/all', 'public');
            $data['image'] = $icon;
        }

        $data['products'] = json_encode($request->input('products'));
        $ads->update($data);

        return redirect()->route('admin.advisedIndex');
    }



    public function deleteAdvised($id){
        $ads = Advised::findOrFail($id);
        $ads->delete();
        return back();
    }

}
