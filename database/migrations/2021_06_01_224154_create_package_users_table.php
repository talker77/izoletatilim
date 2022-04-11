<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('package_id');
            $table->unsignedInteger('invoice_address_id')->nullable();

            $table->date('started_at');
            $table->date('expired_at');
            $table->unsignedFloat('price');
            $table->boolean('is_payment')->default(false);
            $table->json('payment_info')->nullable();

            $table->ipAddress('ip_address');
            $table->unsignedTinyInteger('installment_count')->default(1);
            $table->unsignedFloat('last_price')->nullable();
            $table->uuid('hash');


            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('package_id')->references('id')->on('packages');
            $table->foreign('invoice_address_id')->references('id')->on('kullanici_adres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_users');
    }
}
