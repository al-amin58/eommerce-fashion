<?php


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use JetBrains\PhpStorm\ArrayShape;
use App\Models\BusinessSetting;

if (!function_exists("jsonResponse")){
    #[ArrayShape(["type" => "mixed|string", "status" => "int|mixed", "message" => "mixed|null", "data" => "array|mixed"])]
    function jsonResponse($type="success", $status=200, $data=[], $message=null): array
    {
        return [
          "type" => $type,
          "status" => $status,
          "message" => $message,
          "data" => $data
        ];
    }
}

if (!function_exists("fileResize")){
    function fileResize($file, $storagePath, $width = null, $height = null){
        try {
            $img = Image::make($file->getRealPath())->encode();
            if ($width != null || $height != null){
                $img->resize($width, $height);
            }
            $img->save('storage/'.$storagePath);
            clearstatcache();
        } catch (\Exception $e) {
            Log::error("errors" ,[
                "error message"  => $e
            ]);
        }
    }
}

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        $setting = BusinessSetting::where('type', $key)->first();
        return $setting == null ? $default : $setting->value;
    }
}


if (!function_exists('global_asset')){
    function global_asset($key=null){
        if ($key != null){
            $exists = Storage::disk('public')->has($key);
            if ($exists){
                if (config('app.env' == 'local')){
                    $url = config('app.url') ?? 'http://127.0.0.1:800/'."storage/".$key;
                }else{
                    $url = config('app.url')."/storage/".$key;
                }
            }else{
                $url = config("app.url")."/images/img-placeholder2.webp";
            }
        }else{
            $url = config("app.url")."/images/img-placeholder2.webp";
        }

        return $url;
    }
}

if (!function_exists('overWriteEnvFile')){
    function overWriteEnvFile($type, $val)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"'.trim($val).'"';
            if(is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0){
                file_put_contents($path, str_replace(
                    $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
                ));
            }
            else{
                file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
            }
        }
    }
}

if (!function_exists('overWriteEnv')){
    function overWriteEnv($key, $value){
        $envFile = base_path('.env');
//        $key = "VARIABLE_NAME";
//        $value = "new value";

        if (File::exists($envFile)) {
            // Read the contents of the .env file
            $contents = File::get($envFile);

            // Replace the existing value with the new value
            $updatedContents = Str::replaceFirst(
                "{$key}=" . env($key),
                "{$key}={$value}",
                $contents
            );

            // Write the updated contents back to the .env file
            File::put($envFile, $updatedContents);

            return "Environment variable updated successfully!";
        }

    }
}


if (!function_exists('generate_code')){
    function generate_code(){
        return rand(111111, 999999);
    }
}
