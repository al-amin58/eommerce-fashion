<?php

use App\Models\Address;
use App\Models\OrderArea;
use App\Models\User;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('order_area_id')->index();//->constrained('order_areas');

            $table->integer('cart_total_price')->nullable();
            $table->integer('coupon_discount')->nullable();
            $table->integer('delivery_charge')->nullable();
            $table->integer('grand_total')->nullable();

            $table->date('order_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->enum('order_status', ['pending', 'received', 'process', 'shipped', 'delivered', 'cancel']);
            $table->enum('payment_status', ['pending', 'paid', 'due', 'cancel']);
            $table->boolean('isShow')->default(1);
            $table->string('status')->default(null)->nullable();
            $table->string('transaction_id')->default(null)->nullable();
            $table->string('currency')->default(null)->nullable();
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
        Schema::dropIfExists('orders');
    }
};
