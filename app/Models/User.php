<?php

namespace App\Models;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static paginate(int $int)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'avatar',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function customer(){
        return $this->hasOne(Customer::class);
    }
    public function addresses(){
        return $this->hasMany(Address::class, 'user_id');
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }




    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Storage::url($value) : asset('img/logo.png'),
        );
    }

    public function checkouts(){
        return $this->hasOne(Checkout::class, 'customer_id');
    }

//    protected function created_at(): Attribute
//    {
//        return Attribute::make(
//            get: fn ($value) => $value->format('d-m-Y'),
//        );
//    }

    public function coupons(){
        return $this->belongsToMany(Coupon::class, 'coupon_user')->withPivot(['using', 'using_at'])->withTimestamps();
    }


}
