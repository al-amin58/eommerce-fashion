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
class SubCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


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
        return $this->hasMany(Product::class, 'sub_category_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function childCategories(){
        return $this->hasMany(ChildCategory::class, 'sub_category_id');
    }


}
