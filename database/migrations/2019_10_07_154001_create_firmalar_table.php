<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirmalarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firmalar', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->string('slug', 60)->unique();
//            $table->string('email', 50)->nullable();
            $table->string('address', 250)->nullable();
//            $table->string('phone', 30)->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('api_status')->default(1);
            $table->string('api_url', 255)->nullable();
            $table->string('domain', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('phone', 30)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

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
        Schema::dropIfExists('firmalar');
    }
}
