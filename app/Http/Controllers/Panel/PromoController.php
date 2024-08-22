<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class PromoController extends Controller
{
    public function promos(){
        return inertia('Promo/Index', [
            'banners' => Banner::all(),
            'save_url' => URL::route('admin.savePromo'),
        ]);
    }


    public function savePromo()
    {


//        $data = Request::input("formData.items");

//        foreach (Request::file("formData.items") as $i => $img){
//            $path = $img['image']->store('uploads/all', 'public');
//            fileResize($img['image'], $path, 1500, 500);
//            $images[] = [
//                'path' => $path,
//                'url' => $data[$i]['url'] ?? '#'
//            ];
//        }

        $images = [];
        foreach ($data as $key => $image) {
            if(key_exists("path", $image)){
                $images[] = [
                    'path' => $image["path"],
                    'url' => $image['url'] ?? '#'
                ];
            }else{
                foreach (Request::file("formData.items") as $i => $img){
                    $path = $img['image']->store('uploads/all', 'public');
                    fileResize($img['image'], $path, 1500, 500);
                    $images[] = [
                        'path' => $path,
                        'url' => $data[$i]['url'] ?? '#'
                    ];
                }
            }
        }

        $banner = Banner::findOrFail(1);
        if (count($images) > 0){
            $banner->info = json_encode($images);
        }
        $banner->isNavigate = Request::input('formData')['isNav'];
        $banner->isPaginate = Request::input('formData')['isPeg'];
        $banner->autoPlay = Request::input('formData')['autoPlay'];
        $banner->update();
        return back();
    }



}
