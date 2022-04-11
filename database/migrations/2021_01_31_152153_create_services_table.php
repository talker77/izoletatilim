<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->double('point', 4, 2)->nullable();
            $table->unsignedSmallInteger('country_id')->default(\App\Models\Region\Country::TURKEY)->nullable()->index();
            $table->unsignedInteger('state_id')->nullable()->index();
            $table->unsignedInteger('district_id')->nullable();
            $table->unsignedTinyInteger('status')->default(\App\Models\Service::STATUS_PUBLISHED)->index();
            $table->string('address',255)->nullable();
            $table->string('image')->nullable();
            $table->string('short_description',255)->nullable();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('store_type')->nullable()->default(\App\Models\Service::STORE_TYPE_LOCAL)->index();  // Yerel,Harici Yönlendirme
            $table->unsignedInteger('type_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->decimal('long', 10, 7)->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamp('published_at')->nullable();


            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('type_id')->references('id')->on('service_types');
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
        Schema::dropIfExists('services');
    }
}
