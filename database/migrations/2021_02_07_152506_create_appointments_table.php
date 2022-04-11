<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_company_id')->index();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedFloat('price'); // daily price
            $table->boolean('status')->default(true)->index();

            $table->timestamps();

            $table->foreign('service_company_id')->references('id')->on('service_companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
