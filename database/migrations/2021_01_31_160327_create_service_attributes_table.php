<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('title',100);
            $table->unsignedInteger('type_id');
            $table->string('icon',100)->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('show_menu')->default(false);
            $table->unsignedSmallInteger('order')->nullable();

            $table->foreign('type_id')->references('id')->on('service_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_attributes');
    }
}
