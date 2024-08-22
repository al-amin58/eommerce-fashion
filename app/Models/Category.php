<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @method static create(array $data)
 */
class Category extends Model
{
    use HasFactory;

    protected $guarded = 'id';

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'summery',
        'type',
        'icon',
        'banner',
        'featured',
        'top',
        'digital',
        'order_level',
        'status',
    ];

    use HasSlug;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function childrens()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function subCategories(){
        return $this->hasMany(SubCategory::class, 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    protected function icon(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Storage::url($value) : asset('img/logo.png'),
        );
    }

    protected function banner(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Storage::url($value) : asset('img/logo.png'),
        );
    }

    public function products(){
        return $this->hasMany(Product::class, 'category_id');
    }



    public static function getAll()
    {
        $allCategories = Category::get();
        $rootCategories = $allCategories->whereNull('parent_id');
        self::makeTree($rootCategories, $allCategories);
        return $rootCategories;

        //        foreach ($rootCategories as $category){
//            $category->childrens = $allCategories->where('parent_id', $category->id);
//
//            foreach ($category->childrens as $children){
//                $children->childrens = $allCategories->where('parent_id', $children->id);
//
//                foreach ($children->childrens as $ch){
//                    $ch->childrens =  $allCategories->where('parent_id', $ch->id);
//                    foreach ($ch->childrens as $ch1){
//                        $ch1->childrens =  $allCategories->where('parent_id', $ch1->id);
//                    }
//                }
//            }
//        }
    }

    private static function makeTree($rootCategories , $allCategories)
    {
        foreach ($rootCategories as $category){
            $category->childrens = $allCategories->where('parent_id', $category->id)->values();
            if ($category->childrens->isNotEmpty()){
                self::makeTree($category->childrens, $allCategories);
            }
        }
    }


}
