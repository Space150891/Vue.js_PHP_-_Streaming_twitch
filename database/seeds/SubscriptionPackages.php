<?php

use Illuminate\Database\Seeder;

class SubscriptionPackages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('subscription_plans')->delete();
        $now = date('Y-m-d H:i:s', time());
        \DB::table('subscription_plans')->insert([
            ['cost' => 9.99, 'name' =>  'basic', 'points' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['cost' => 19.99, 'name' => 'advanced', 'points' => 10, 'created_at' => $now, 'updated_at' => $now],
            ['cost' => 49.99, 'name' =>  'golden', 'points' => 55, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
