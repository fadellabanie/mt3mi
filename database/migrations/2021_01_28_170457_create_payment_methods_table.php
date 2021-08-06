<?php

use App\Models\PaymentMethod;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('type');
            $table->tinyInteger('auto_open_cash_drawer')->default(0);
            $table->tinyInteger('is_active')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        /*PaymentMethod::create([
            'name' => 'Cash',
            'type' => 'Cash',
            'auto_open_cash_drawer' => 1,
            'is_active' => 1
        ]);*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}
