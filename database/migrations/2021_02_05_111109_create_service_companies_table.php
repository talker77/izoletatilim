<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_companies', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->boolean('status')->default(true);
            $table->string('redirect_to',255)->nullable();
            $table->unsignedBigInteger('service_id')->index();
            $table->unsignedBigInteger('company_id')->index();
            $table->json('response')->nullable(); // API RESPONSE PER ITEM

            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('company_id')->references('id')->on('firmalar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_companies');
    }
}
