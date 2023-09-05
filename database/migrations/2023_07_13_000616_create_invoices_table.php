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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('order_no')->nullable();
            $table->enum('status',['0','1'])->default('0');
            $table->string('c_name')->nullable();
            $table->string('c_email_address')->nullable();
            $table->string('c_phone')->nullable();
            $table->string('c_companyname')->nullable();
            $table->string('c_country')->nullable();
            $table->string('c_city')->nullable();
            $table->string('c_address')->nullable();
            $table->string('c_state_country')->nullable();
            $table->string('c_postal_zip')->nullable();
            $table->string('order_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
