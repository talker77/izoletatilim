<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceCompanyCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_company_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->index();
            $table->unsignedBigInteger('service_company_id')->index();
            $table->string('full_name')->nullable();
            $table->string('message',255);
            $table->boolean('status')->default(true)->index();
            $table->unsignedTinyInteger('point')->index(); // 1 - 10
            $table->timestamp('read_at')->nullable();
            $table->timestamps();


            $table->foreign('service_id')->references('id')->on('services');
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
        Schema::dropIfExists('service_company_comments');
    }
}
