<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;


    protected $guarded = ['id'];


    public function customerCart(){
        return $this->belongsTo(CustomerCart::class);
    }

    public function orderArea(){
        return $this->belongsTo(OrderArea::class);
    }

    protected $dates = [
        'checkout_date'
    ];


}
