<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimedEventOrderTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timed_event_order_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timed_event_id')->constrained('timed_events', 'id')->onDelete('cascade');
            $table->foreignId('order_type_id')->constrained('order_types', 'id')->onDelete('cascade');
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
        Schema::dropIfExists('timed_event_order_types');
    }
}
