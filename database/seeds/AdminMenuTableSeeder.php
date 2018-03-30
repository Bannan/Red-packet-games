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
                ['id' => 8, 'parent_id' => 0, 'order' => 0, 'title' => '游戏配置', 'icon' => 'fa-gamepad', 'uri' => null],
                ['id' => 9, 'parent_id' => 8, 'order' => 0, 'title' => '游戏列表', 'icon' => 'fa-yelp', 'uri' => 'games'],
                ['id' => 10, 'parent_id' => 8, 'order' => 0, 'title' => '游戏大厅', 'icon' => 'fa-angellist', 'uri' => 'screenings'],
                ['id' => 11, 'parent_id' => 0, 'order' => 0, 'title' => '代理层级', 'icon' => 'fa-expeditedssl', 'uri' => 'levels'],
                ['id' => 12, 'parent_id' => 0, 'order' => 0, 'title' => '注册会员', 'icon' => 'fa-user', 'uri' => 'users'],
            ]);
        }
    }
}
