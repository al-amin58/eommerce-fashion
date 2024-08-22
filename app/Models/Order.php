<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($id)
 */
class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function orderDetails(){
        return $this->hasMany(OrderDetails::class);
    }

    public function customer(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function address(){
        return $this->belongsTo(Address::class,'order_area_id');
    }

}
