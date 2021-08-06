<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTillOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('till_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('till_id')->constrained()->onDelete('cascade');
            $table->date('business_date')->default(Carbon::today());
            $table->string('type')->comment('pay_in, pay_out, cash_drop');
            $table->decimal('amount', 10, 2);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('till_operations');
    }
}
