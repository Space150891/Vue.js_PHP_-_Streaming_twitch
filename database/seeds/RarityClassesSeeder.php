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
            [
                'name'      =>  'common',
                'special'   =>  0
            ],
            [
                'name'      =>  'uncommon',
                'special'   =>  0
            ],
            [
                'name'      =>  'rare',
                'special'   =>  0
            ],
            [
                'name'      =>  'epic',
                'special'   =>  0
            ],
            [
                'name'      =>  'legendary',
                'special'   =>  0
            ],
            [
                'name'      =>  'default',
                'special'   =>  1
            ],
            [
                'name'      =>  'twitter',
                'special'   =>  1
            ],
            [
                'name'      =>  'facebook',
                'special'   =>  1
            ],
            [
                'name'      =>  'random',
                'special'   =>  1
            ],
        ];
        foreach ($data as $d) {
            $find = RarityClass::where('name', $d['name'])->first();
            if (!$find) {
                $rarity = new RarityClass();
                $rarity->name = $d['name'];
                $rarity->special = $d['special'];
                $rarity->save();
                echo "\n seed id=" . $rarity->id;
            }
        }
        echo "\n done \n";
    }
}
