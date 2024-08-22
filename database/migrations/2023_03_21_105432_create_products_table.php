<?php

use App\Models\ActiveColor;
use App\Models\Brand;
use App\Models\Category;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->foreignIdFor(User::class, 'user_id')->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(Category::class, 'category_id')->constrained('categories')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(Brand::class, 'brand_id')->nullable()->constrained('brands')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->bigInteger( 'active_color_id')->nullable();//->constrained('active_colors');

            $table->string('title');
            $table->string('slug')->unique();

            $table->integer('price')->default(0);
            $table->integer('discount')->default(0);
            $table->enum('discount_type', ['percentage', 'flat'])->nullable();
            $table->string('unit')->nullable();
            $table->integer('qty')->default(0);
            $table->integer('low_stoke_qty')->default(0);

            $table->string('thumbnail')->nullable();
            $table->longText('images')->nullable();
            $table->longText('sizes')->nullable();

            $table->mediumText('description')->nullable();
            $table->longText('specification')->nullable();

            $table->string('shipping_type')->nullable();
            $table->integer('inside_in_dhaka')->default(0);
            $table->integer('outside_in_dhaka')->default(0);

            $table->boolean('cod')->default(false);

            $table->integer('tax')->nullable()->default(0);
            $table->enum('tax_type', ['percentage', 'flat'])->nullable();
            $table->integer('vat')->nullable()->default(0);
            $table->enum('vat_type', ['percentage', 'flat'])->nullable();
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
        Schema::dropIfExists('products');
    }
};
