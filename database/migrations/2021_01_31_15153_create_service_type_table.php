<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100);
            $table->string('slug',140);
            $table->unsignedInteger('parent_id')->nullable();
            $table->boolean('status')->default(true);
            $table->string('image')->nullable();

//            $table->string('page_title')->nullable();
//            $table->string('page_sub_title')->nullable();
//            $table->string('short_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_types');
    }
}
