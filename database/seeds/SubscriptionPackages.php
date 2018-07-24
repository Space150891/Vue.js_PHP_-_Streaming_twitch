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
            ['cost' => 9.99, 'name' =>  'basic', 'created_at' => $now, 'updated_at' => $now],
            ['cost' => 19.99, 'name' => 'advanced', 'created_at' => $now, 'updated_at' => $now],
            ['cost' => 49.99, 'name' =>  'golden', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
