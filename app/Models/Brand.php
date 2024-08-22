<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Brand extends Model
{
    use HasFactory, HasSlug;
    protected $table ="brands";
    protected $fillable = ['name', 'slug', 'icon', 'banner', 'order_level'];


    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }



    protected function icon(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Storage::url($value) : '/images/avatar.png',
        );
    }

    public function products(){
        return $this->hasMany(Product::class, 'category_id');
    }

}
