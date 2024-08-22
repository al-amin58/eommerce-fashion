<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Properties;
use App\Models\Address;
use App\Models\Checkout;
use App\Models\Coupon;
use App\Models\CustomerCart;
use App\Models\District;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class CheckoutController extends Controller
{
    public function checkout(){
        $address = User::with('addresses', 'addresses.orderArea')->findOrFail(Auth::id());

        return inertia('Frontend/Customer/Checkout', [
            'main_url' => URL::route('addCheckout'),
            "user" => $address,
            "checkOutData" => Session::get('checkoutData'),
            'apply_coupon_url' => URL::route('applyCoupon'),
        ]);
    }


    public function addCheckout(){
        $data = Request::all();


//        return dd(Request::all());


        $deliveryCharge = 0;
        $couponDiscount = 0;
        if ($data['cartTotalPrice'] > $data['address']['charge_condition']){
            $deliveryCharge = $data['address']['charge_condition_price'];
        }else{
            $deliveryCharge = $data['address']['delivery_charge'];
        }

        if ($data['couponData']){
            $couponDiscount = $data['couponDiscount'];
        }

        $grandTotalWithDiscount = $data['cartTotalPrice'] - $couponDiscount;
        $grandTotal = $grandTotalWithDiscount + $deliveryCharge;



        if (Properties::$cartSaveDb){
            $cart = CustomerCart::create([
                'user_id' => Auth::id(),
                'cartItems' => json_encode(Request::input('cartItems'))
            ]);
            $checkout = Checkout::create([
                'user_id' => Auth::id(),
                "customer_cart_id" => $cart->id,
                "delivery_charge" => $deliveryCharge,
                "coupon_id" => Request::input('couponData') ? Request::input('couponData')['id'] : null,
                "order_area_id" => Request::input('address')['id'],
                "cart_total_price" => $data['cartTotalPrice'],
                "grand_total" => $grandTotal,
                "checkout_date" => now()->format('d-m-Y'),
                "totalItems" => Request::input('totalItems')
            ]);
        }else{
            // just for  session system
            $saveCheckoutData = [
                'user_id' => Auth::id(),
                "customer_cart_id" => [
                    'user_id' => Auth::id(),
                    'cartItems' => json_encode(Request::input('cartItems'))
                ],
                "coupon_id" => Request::input('couponData') ? Request::input('couponData')['id'] : null,
                "order_area_id" => Request::input('address')['id'],

                "cart_total_price" => $data['cartTotalPrice'],
                "delivery_charge" => $deliveryCharge,
                "coupon_discount" => $couponDiscount,
                "grand_total" => $grandTotal,

                "checkout_date" => now()->format('d-m-Y'),
                "totalItems" => Request::input('totalItems')
            ];
        }




        Session::remove('checkoutData');
        Session::put('checkoutData', [
            "data" => Properties::$cartSaveDb ? $checkout :  $saveCheckoutData,
        ]);

//        return inertia('Frontend/Customer/Checkout', [
//            "checkOutData" => Session::get('checkoutData'),
//            'info' => [
//                "status"=>200,
//                "message" => 'Checkout Successful, Make Payment Now...'
//            ]]);
        return redirect()->route('payment');
    }


    public function applyCoupon(){

        Request::validate([
            'data' => 'required'
        ],[
            'data.required' => "First Fillip Coupon Code field."
        ]);

        $code = Coupon::where('code', Request::input('data'))->first();

        if ($code){
            if ($code->status){
                if ($code->validate && $code->validate >= today()->format("Y-m-d")){
                    $users =  $code->users->where('pivot.user_id', Auth::id());
//                    if ($users && $users->count() < $code->limit){
                        return Response::json([
                            'status' => 200,
                            'code' => $code,
                        ]);

//                    }else{
//                        return Response::json([
//                            'status' => 404,
//                            'message' => "Coupon Code Use Limit Expired..."
//                        ]);
//                    }
                }else{
                    return Response::json([
                        'status' => 404,
                        'message' => "Date Expired For This Coupon Code..."
                    ]);
                }
            }else{
                return Response::json([
                    'status' => 404,
                    'message' => "Coupon Code Is Not Active..."
                ]);
            }

        }else{
            return Response::json([
                'status' => 404,
                'message' => "Coupon Code Not Exist..."
            ]);
        }
    }



}
