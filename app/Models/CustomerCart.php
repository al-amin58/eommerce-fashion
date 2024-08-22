<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCart extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function checkout(){
        return $this->hasOne(Checkout::class);
    }

}
