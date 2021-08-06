<?php

use App\Models\OrderType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_types', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->timestamps();
        });

        OrderType::create([
            'name_ar' => 'Dine in',
            'name_en' => 'محلي'
        ]);

        OrderType::create([
            'name_ar' => 'Takeaway',
            'name_en' => 'خارجي'
        ]);

        OrderType::create([
            'name_ar' => 'Pickup',
            'name_en' => 'استلام'
        ]);

        OrderType::create([
            'name_ar' => 'Delivery',
            'name_en' => 'توصيل'
        ]);

        OrderType::create([
            'name_ar' => 'Drive Thru',
            'name_en' => 'سيارة'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_types');
    }
}
