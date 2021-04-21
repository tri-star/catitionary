<?php

namespace Database\Seeders;

use App\Domain\CatCharacterics;
use Illuminate\Database\Seeder;

class CatCharactericsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'hachiware'   => 'ハチワレ',
            'massive'     => 'どっしり',
            'kinked-tail' => 'カギしっぽ',
        ];

        foreach ($types as $id=>$name) {
            $characterics = new CatCharacterics([
                'id'   => $id,
                'name' => $name,
            ]);
            $characterics->save();
        }
    }
}
