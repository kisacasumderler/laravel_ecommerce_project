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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->text('content');

            $table->text('text_1');
            $table->text('text_1_icon');
            $table->text('text_1_content');
            $table->text('text_2');
            $table->text('text_2_icon');
            $table->text('text_2_content');
            $table->text('text_3');
            $table->text('text_3_icon');
            $table->text('text_3_content');
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
        Schema::dropIfExists('abouts');
    }
};
