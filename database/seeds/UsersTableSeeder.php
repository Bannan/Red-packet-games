<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::where('mobile', '18613233254')->count() === 0) {
            User::create([
                'mobile' => '18613233254',
                'password' => bcrypt('bing8u'),
                'safety_code' => bcrypt('bing8u'),
                'nickname' => '春光灿烂',
                'balance' => 99999.99,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        };
    }
}