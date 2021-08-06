<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('type');
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->float('quantity')->default(0);
            $table->string('purchase_unit');
            $table->string('storage_unit');
            $table->string('ingredient_unit');
            $table->float('purchase_to_storage_factor');
            $table->float('storage_to_ingredient_factor');
            $table->string('cost_type');
            $table->float('cost')->default(0);
            $table->float('minimum_level_alert');
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade')->nullable();
            $table->date('expiration_date')->nullable();
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
        Schema::dropIfExists('inventory_items');
    }
}
