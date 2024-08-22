<?php

use App\Models\Address;
use App\Models\Customer;
use App\Models\CustomerCart;
use App\Models\OrderArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class, 'user_id')->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignIdFor(CustomerCart::class, 'customer_cart_id')->constrained('customer_carts')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unsignedBigInteger('order_area_id')->index();//->nullable()->constrained('order_areas');

            $table->unsignedBigInteger('coupon_id')->index();
//            $table->foreign('coupon_id')->references('id')->on('coupons');

            $table->integer('cart_total_price')->nullable();
            $table->integer('coupon_discount')->nullable();
            $table->integer('delivery_charge')->nullable();
            $table->integer('grand_total')->nullable();

            $table->date('checkout_date')->nullable();
            $table->date('clear_date')->nullable()->comment('if you want to automatically clear checkout after some day then need this fields');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkouts');
    }
};
