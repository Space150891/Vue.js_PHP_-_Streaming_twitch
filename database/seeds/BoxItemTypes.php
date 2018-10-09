<?php

use Illuminate\Database\Seeder;
use App\Models\HistoryBoxItemType;

class BoxItemTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'nothing', 'prize', 'hero', 'frame', 'points', 'diamonds'
        ];
        foreach ($data as $d) {
            $boxType = new HistoryBoxItemType();
            $boxType->name = $d;
            $boxType->save();
        }
    }
}
