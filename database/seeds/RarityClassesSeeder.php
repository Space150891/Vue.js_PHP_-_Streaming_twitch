<?php

use Illuminate\Database\Seeder;
use App\Models\RarityClass;

class RarityClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'plain',
            'default',
            'uncommon',
            'rare',
            'epic',
            'legendary',
            'default',
            'twitter',
            'facebook',
            'random',
        ];
        foreach ($data as $d) {
            $find = RarityClass::where('name', $d)->first();
            if (!$find) {
                $rarity = new RarityClass();
                $rarity->name = $d;
                $rarity->save();
                echo "\n seed id=" . $rarity->id;
            }
        }
        echo "\n done \n";
    }
}
