<?php

use Illuminate\Database\Seeder;
use App\Models\AlertType;

class AlertTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!AlertType::first()) {
            AlertType::create([
                'name'  => 'SMS'
            ]);
            AlertType::create([
                'name'  => 'email'
            ]);
            AlertType::create([
                'name'  => 'browser'
            ]);
        }
    }
}
