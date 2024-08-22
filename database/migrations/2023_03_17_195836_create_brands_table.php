<?php

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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('slogan')->nullable();
            $table->text('summery')->nullable();
            $table->string('icon')->nullable();
            $table->string('banner')->nullable();
            $table->boolean('featured')->default(false)->comment('0 = false, 1 = true');
            $table->boolean('top')->default(false)->comment('0 = false, 1 = true');
            $table->integer('order_level')->default(0)->comment('low number high priority');
            $table->integer('level')->default(0);
            $table->enum('status', ['published', 'cancel', 'pending', 'deleted'])->default('pending');
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
        Schema::dropIfExists('brands');
    }
};
