<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrunYorumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urun_yorumlar', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('product_id');
            $table->boolean('active')->default(0);
            $table->boolean('is_read')->default(0);
            $table->string('message', 255);
            $table->unsignedTinyInteger('point')->default(5);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('urunler')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urun_yorumlar');
    }
}
