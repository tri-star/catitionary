<?php

namespace Database\Seeders;

use App\Domain\CatType;
use Illuminate\Database\Seeder;

class CatTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'kijitora'  => 'キジトラ',
            'kijishiro' => 'キジシロ',
            'hachiware' => 'ハチワレ',
        ];

        foreach ($types as $id=>$name) {
            if (CatType::where('key', $id)->count() > 0) {
                continue;
            }
            $catType = new CatType([
                'key'  => $id,
                'name' => $name,
            ]);
            $catType->save();
        }
    }
}
