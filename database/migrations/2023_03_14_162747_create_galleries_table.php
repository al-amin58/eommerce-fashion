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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->integer('imageable_id')->comment('model_id');
            $table->string('imageable_type')->comment('model_name')->nullable();
            $table->string('file_original_name')->nullable();
            $table->string('file_name')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('file_size')->nullable();
            $table->string('extension')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('galleries');
    }
};
