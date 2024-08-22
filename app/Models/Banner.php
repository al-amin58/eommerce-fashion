<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use HasFactory;


    protected $fillable = [
      'info', 'isNavigate', 'isPaginate', 'autoPlay'
    ];


//autoPlay
    protected function autoPlay(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? true : false,
        );
    }



}
