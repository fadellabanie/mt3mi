<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
            
            $table->after('password', function ($table) {
                $table->string('pin_code')->nullable();
                $table->decimal('salary', 10, 2)->nullable();
                $table->string('business_role')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('pin_code');
            $table->dropColumn('salary');
            $table->dropColumn('business_role');
        });
    }
}
