<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->foreignId('cashier_id')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('till_id')->constrained()->onDelete('cascade')->nullable();
            $table->foreignId('order_type_id')->constrained()->onDelete('cascade');
            $table->integer('persons')->nullable();
            $table->text('notes')->nullable();
            $table->string('call_name')->nullable();
            $table->foreignId('coupon_id')->constrained()->onDelete('cascade')->nullable();
            $table->dateTime('due_time')->nullable();
            $table->foreignId('join_order')->constrained('orders', 'id')->onDelete('cascade')->nullable();
            $table->string('status')->default('new');
            $table->foreignId('payment_method_id')->constrained()->onDelete('cascade');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
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
        Schema::dropIfExists('orders');
    }
}
