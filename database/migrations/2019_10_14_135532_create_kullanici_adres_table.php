<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKullaniciAdresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kullanici_adres', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50);
            $table->string('name', 50);
            $table->string('email', 50);
            $table->string('surname', 50);
            $table->string('phone', 20);
            $table->unsignedSmallInteger('type')->default(1);
            $table->string('address', 255);

            $table->unsignedSmallInteger('country_id')->default(1);
            $table->unsignedInteger('state_id');
            $table->unsignedInteger('district_id');
            $table->unsignedInteger('neighborhood_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('neighborhood_id')->references('id')->on('neighborhoods');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kullanici_adres');
    }
}
