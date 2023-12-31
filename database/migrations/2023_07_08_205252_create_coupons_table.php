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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->double('price',8,2)->nullable();
            $table->integer('discount_rate')->nullable();
            $table->integer('qty')->default(0);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->enum('status',['0','1'])->default('0');
            $table->enum('isDiscount',['0','1'])->default('0');
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
        Schema::dropIfExists('coupons');
    }
};
