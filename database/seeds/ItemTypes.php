<?php

use Illuminate\Database\Seeder;

class ItemTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('item_types')->delete();
        $now = date('Y-m-d H:i:s', time());
        // 2018-07-10 14:38:38
        \DB::table('item_types')->insert([
            ['id' => 1,   'name' =>  'frame', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2,   'name' =>  'hero', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3,   'name' =>  'price', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
