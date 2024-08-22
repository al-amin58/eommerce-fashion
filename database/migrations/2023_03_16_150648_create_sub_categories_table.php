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
        Schema::create('sub_categories', function (Blueprint $table) {

            $table->id();
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->string('banner')->nullable();
            $table->boolean('featured')->default(false)->comment('0 = false, 1 = true');
            $table->boolean('top')->default(false)->comment('0 = false, 1 = true');
            $table->string('type')->default('physical');//->comment('0 = false, 1 = true');
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
        Schema::dropIfExists('sub_categories');
    }
};
