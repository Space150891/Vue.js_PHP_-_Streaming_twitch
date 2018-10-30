<?php

use Illuminate\Database\Seeder;
use App\Models\PrizeType;

class PrizeTypes extends Seeder
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
                'name'      =>  'CD-Key',
            ],
            [
                'name'      =>  'Hardware',
            ],
        ];
        foreach ($data as $d) {
            $find = PrizeType::where('name', $d['name'])->first();
            if (!$find) {
                $type = new PrizeType();
                $type->name = $d['name'];
                $type->save();
                echo "\n seed id=" . $type->id;
            }
        }
        echo "\n done \n";
    }
}
