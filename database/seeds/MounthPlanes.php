<?php

use Illuminate\Database\Seeder;

class MounthPlanes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('mounth_plans')->delete();
        $now = date('Y-m-d H:i:s', time());
        // 2018-07-10 14:38:38
        \DB::table('mounth_plans')->insert([
            ['monthes' => 1,   'percent' =>  0, 'created_at' => $now, 'updated_at' => $now],
            ['monthes' => 3,   'percent' =>  5, 'created_at' => $now, 'updated_at' => $now],
            ['monthes' => 6,   'percent' =>  10, 'created_at' => $now, 'updated_at' => $now],
            ['monthes' => 12,  'percent' =>  20, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
