<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('till_id')->nullable()->change();
            $table->integer('persons')->nullable()->change();
            $table->text('notes')->nullable()->change();
            $table->string('call_name')->nullable()->change();
            $table->foreignId('coupon_id')->nullable()->change();
            $table->dateTime('due_time')->nullable()->change();
            $table->foreignId('join_order')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
