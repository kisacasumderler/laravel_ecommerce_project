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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->double('price',8,2)->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('short_text')->nullable();
            $table->longText('content')->nullable();
            $table->integer('qty')->default(0);
            $table->integer('kdv')->default(0);
            $table->integer('tax_free_price')->default(0);
            $table->enum('status',['0','1'])->default('0');
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
