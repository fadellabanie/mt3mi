<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('business_date')->useCurrent();
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->float('paid_tax')->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('inventory_item_id')->constrained()->onDelete('cascade');
            $table->float('purchase_quantity')->default(0);
            $table->float('storage_quantity')->default(0);
            $table->float('ingredient_quantity')->default(0);
            $table->float('cost')->default(0);
            $table->date('expiration_date')->nullable();
            $table->string('status')->default('pending');
            $table->softDeletes();
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
        Schema::dropIfExists('inventory_transactions');
    }
}
