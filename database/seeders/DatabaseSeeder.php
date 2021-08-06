<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $restaurant =  Restaurant::create([
            'name' => 'eclick',
            'registered_at' => Carbon::today()
        ]);

        User::create([
            'restaurant_id' => $restaurant->id,
            'name' => 'Restaurant1',
            'type' => 'owner',
            'dial_code' => '+966',
            'phone' => '501234567',
            'email' => 'rest@eclick.com',
            'password' => Hash::make('password'),
            'language' => 'ar',
        ]);
    }
}
