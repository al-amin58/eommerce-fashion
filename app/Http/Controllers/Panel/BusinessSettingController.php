<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Advised;
use App\Models\BusinessSetting;
use App\Models\Category;
use App\Models\Country;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\SubCategory;
use Dotenv\Dotenv;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class BusinessSettingController extends Controller
{
    public function index()
    {
        return inertia('Settings/Setting', [
            'main_url' => URL::route('admin.businessSave'),
            'categories' => Category::with('childrens')->get(),
            'subCategories' => SubCategory::query()->get(),
            'products' => Product::with('category:id,title')->get(),
            'updateSmtp' => URL::route('admin.updateSmtp'),
            'bSettings' =>[
                'name'        => get_setting('name'),
                'details'     => get_setting('app_details'),

                'header_logo' => get_setting('header_logo'),
                'footer_logo' => get_setting('footer_logo'),
                'fevicon_logo'=> get_setting('logo_fabs'),

                'timezone'    => json_decode(get_setting('timezone')),
                'country'     => json_decode(get_setting('country')),

                'address'     => get_setting('address'),
                'phone'       => get_setting('phone'),
                'email'       => get_setting('email'),

                'api_user_pass'  => get_setting('api_user_pass'),
                'api_user_name'  => get_setting('api_user_name'),
                'api_url'        => get_setting('api_url'),

                'instagram_profile'       => get_setting('instagram_profile'),
                'facebook_profile'        => get_setting('facebook_profile'),
                'youtube'                 => get_setting('youtube'),
                'google_drive'            => get_setting('google_drive'),
                'linkedin_profile'        => get_setting('linkedin_profile'),
                'twitter_profile'         => get_setting('twitter_profile'),
                'header_categories' => json_decode(get_setting('header_categories')),
                'headerMenuSetup' => json_decode(get_setting('headerMenuSetup')),
                'home_seo_content' =>  get_setting('home_seo_content'),

                'mailDriver' => get_setting('mailDriver'),
                'mailHost' => get_setting('mailHost'),
                'mailPort' => get_setting('mailPort'),
                'username' => get_setting('username'),
                'password' => get_setting('password'),
                'fromEmail' => get_setting('fromEmail'),
                'fromName' => get_setting('fromName'),

                'home_products'=> json_decode(get_setting('home_products')),

                'menu_categories'=> json_decode(get_setting('menu_categories')),
                'featured_categories'=> json_decode(get_setting('featured_categories')),
            ]
        ]);
    }

    public function updateSetting()
    {

        foreach (Request::all() as $type => $value){
            $business_settings = BusinessSetting::where('type', $type)->first();

            if ($type == 'name' && $value != null){
                overWriteEnv("APP_NAME", $value);
            }

            if ($type == 'timezone' && gettype($value) == 'array'){
                overWriteEnv("APP_TIMEZONE", $value['tz']);
            }

            if ($type == 'country' && $value != null && gettype($value) != 'array'){
                $value = $business_settings->country;
            }

            if ($type == 'timezone' && gettype($value) == 'array'){
                overWriteEnv("TEXT_COLOR", $value['tz']);
            }

            if ($type == 'header_logo' && Request::hasFile('header_logo')){
                $value = Request::file('header_logo')->store('settings', 'public');
            }

            if ($type == 'footer_logo' && Request::hasFile('footer_logo')) {
                $value = Request::file('footer_logo')->store('settings', 'public');
            }

            if ($type == 'logo_fabs' && Request::hasFile('logo_fabs')) {
                $value = Request::file('logo_fabs')->store('settings', 'public');
            }

            if($business_settings != null) {
                if ($value != null){
                    if ($type == 'timezone' && gettype($value) != 'array'){
                        $value = $business_settings->value;
                    }
                    if(gettype($value) == 'array'){
                        $business_settings->value = json_encode($value);
                    }
                    else {
                        $business_settings->value = $value;
                    }
                    $business_settings->save();
                }
            } else{
                if ($value != null){
                    $business_settings = new BusinessSetting;
                    $business_settings->type = $type;
                    if(gettype($value) == 'array'){
                        $business_settings->value = json_encode($value);
                    }
                    else {
                        $business_settings->value = $value;
                    }
                    $business_settings->save();
                }
            }
        }
        return redirect()->back();
    }

    public function logoUpdate(){


        if (Request::hasFile('header_logo')){
            $business_settings = BusinessSetting::where('type', 'header_logo')->first();
            if ($business_settings?->value != null){
                Storage::disk('public')->delete($business_settings->value);
            }
            $value = Request::file('header_logo')->store('settings', 'public');
            $business_settings->value = $value;
            $business_settings->save();
        }
        if (Request::hasFile('footer_logo')){
            $business_settings = BusinessSetting::where('type', 'footer_logo')->first();
            if ($business_settings?->value != null){
                Storage::disk('public')->delete($business_settings->value);
            }
            $value = Request::file('footer_logo')->store('settings', 'public');
            $business_settings->value = $value;
            $business_settings->save();
        }

        if (Request::hasFile('logo_fabs')){



//            $business_settings = BusinessSetting::where('type', 'logo_fabs')->first();
//            if ($business_settings?->value != null){
//                Storage::disk('public')->delete($business_settings->value);
//            }
//            $value = Request::file('logo_fabs')->store('settings', 'public');
//            $business_settings->value = $value;
//            $business_settings->save();
        }


        Log::info('Update Business Settings', [
            'message' => 'Update Successfully Done...!',
            'time' => now()
        ]);

        return redirect()->route('setting.index');
    }


    public function updateSmtp(){
        foreach (Request::all() as $type => $value) {
            $business_settings = BusinessSetting::where('type', $type)->first();
            if ($type == 'mailDriver' && $value != null){
                overWriteEnv("MAIL_MAILER", $value);
            }
            if ($type == 'mailHost' && $value != null){
                overWriteEnv("MAIL_HOST", $value);
            }
            if ($type == 'mailPort' && $value != null){
                overWriteEnv("MAIL_PORT", $value);
            }
            if ($type == 'username' && $value != null){
                overWriteEnv("MAIL_USERNAME", $value);
            }
            if ($type == 'password' && $value != null){
                overWriteEnv("MAIL_PASSWORD", $value);
            }
            if ($type == 'fromEmail' && $value != null){
                overWriteEnv("MAIL_FROM_ADDRESS", $value);
            }
            if ($type == 'fromName' && $value != null){
                overWriteEnv("MAIL_FROM_NAME", $value);
            }
            if ($type == 'encryption' && $value != null){
                overWriteEnv("MAIL_ENCRYPTION", $value);
            }


            if($business_settings != null) {
                if ($value != null){
                    if(gettype($value) == 'array'){
                        $business_settings->value = json_encode($value);
                    }
                    else {
                        $business_settings->value = $value;
                    }
                    $business_settings->save();
                }
            } else{
                if ($value != null){
                    $business_settings = new BusinessSetting;
                    $business_settings->type = $type;
                    if(gettype($value) == 'array'){
                        $business_settings->value = json_encode($value);
                    }
                    else {
                        $business_settings->value = $value;
                    }
                    $business_settings->save();
                }
            }


        }
        return back();
    }



}
