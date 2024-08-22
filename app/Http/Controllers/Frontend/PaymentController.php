<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Properties;
use App\Models\Checkout;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class PaymentController extends Controller
{
    public function payment(){
        return inertia('Frontend/Customer/Payment',[
            'make_payment' => URL::route('makePayment'),
            'info' => [
                "status"=>200,
                "message" => 'Checkout Successful, Make Payment Now...'
            ],
            'checkoutData' => Session::get('checkoutData')
        ]);
    }

    public function makePayment(){
        $checkout =  Session::get('checkoutData');
        $cartItems = [];
        if (Properties::$cartSaveDb){
            $checkoutDetails = Checkout::with(['customerCart', 'orderArea'])->where('id', $checkout["data"]['id'],)->first();
            $cartItems = json_decode($checkoutDetails->customerCart->cartItems);
        }else{
            $cartItems = json_decode($checkout['data']['customer_cart_id']['cartItems']);
        }



//        return dd($checkout);



        $order = Order::create([
            'user_id' => Auth::id(),
            "order_area_id" => $checkout['data']['order_area_id'],

            "cart_total_price" => $checkout['data']['cart_total_price'],
            "delivery_charge" => $checkout['data']['delivery_charge'],
            "coupon_discount" => $checkout['data']['coupon_discount'],
            "grand_total" => $checkout['data']['grand_total'],

            'order_date' => now()->format('d-m-y'),
            'payment_method' => Request::input('formData')['paymentMethod'],
            'order_status' => 'pending',
            'payment_status' => 'pending',
        ]);

//        return $order;

        foreach ($cartItems as $item){
            OrderDetails::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'quantity' => $item->quantity,
                'buy_size' => $item->size ?? null,
            ]);
        }

        Session::forget('checkoutData');
        if (Properties::$cartSaveDb) {
            $checkoutDetails->customerCart->delete();
            $checkoutDetails->delete();
        }

        return inertia('Frontend/Customer/Conformation',[
            "order" => Order::orderBy('id', 'desc')->first()?->load('customer:id,name','address','orderDetails', 'orderDetails.product') ?? [],
            'info' => [
                "status"=>200,
                "message" => 'Checkout Successful, Make Payment Now...'
            ]
        ]);
    }

    public function orderComplete(){
        return inertia('Frontend/Customer/Conformation',[
            "order" => Order::orderBy('id', 'desc')->first()?->load('customer:id,name','address','orderDetails', 'orderDetails.product'),
            'info' => [
                "status"=>200,
                "message" => 'Checkout Successful, Make Payment Now...'
            ]
        ]);
    }

}
