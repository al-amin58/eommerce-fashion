<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Properties;
use App\Models\Advised;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Support\Facades\URL;

class HomeSettingController extends Controller
{
    public function homePageSettings(){

        $topProducts = json_decode(get_setting('topProducts'));
        $topCategory = json_decode(get_setting('categories1'));
        $homeCategories = json_decode(get_setting('categories2'));
        $ads1 = json_decode(get_setting('add1'));
        $ads2 = json_decode(get_setting('add2'));
        $add3 = json_decode(get_setting('add3'));
        $ads4 = json_decode(get_setting('add4'));
        $add5 = json_decode(get_setting('add5'));
        return inertia('Settings/HomeSetting', [
            'advised' => Advised::where('status', 1)->get(),
            'products' => Product::with(['category:id,title', 'brand:id,name'])->get(),
            'categories' => Category::with('childrens')->get(),
            'brands' => Brand::all(),
            'homeSettings' => [
                'add1' => $ads1,
                'add2' => $ads2,
                'add3' => $add3,
                'add4' => $ads4,
                'add5' => $add5,
                'topProducts' => $topProducts,
                'homeCategories' => $homeCategories,
                'topCategories' => $topCategory
            ],
            'main_url' => URL::route('admin.businessSave'),
        ]);
    }



    public function footerSettings(){
        $topProducts = json_decode(get_setting('customPages'));
        return inertia('Settings/FooterSetting',[
            'pages' => Page::all(),
            'savePages' => $topProducts,
            'main_url' => URL::route('admin.businessSave'),
        ]);
    }

}
