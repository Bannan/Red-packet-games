<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('admin_menu')->count() < 8) {
            DB::table('admin_menu')->insert([

            ]);
        }
    }
}
