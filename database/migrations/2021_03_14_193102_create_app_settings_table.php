<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('order_type_id')
                ->constrained()
                ->onDelete('cascade');
            $table->integer('logout_inactive_after')->nullable();
            $table->integer('reset_order_number_after')->nullable();
            $table->tinyInteger('void_require_customer_info')->default(false);
            $table->tinyInteger('discount_require_customer_info')->default(false);
            $table->tinyInteger('run_in_submode')->default(false);
            $table->string('receipt_language')->default('ar');
            $table->string('waiter_app_background')->nullable();
            $table->string('cashier_app_background')->nullable();
            $table->string('customer_app_background')->nullable();
            $table->string('receipt_logo')->nullable();
            $table->longText('receipt_header')->nullable();
            $table->longText('receipt_footer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_settings');
    }
}
