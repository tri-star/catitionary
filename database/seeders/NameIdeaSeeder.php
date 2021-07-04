<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domain\Name\NameIdea;
use App\Domain\Name\NamePattern;
use Illuminate\Database\Seeder;

class NameIdeaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var NameIdea[] */
        $nameIdeas = NameIdea::factory()
            ->count(10)
            ->make();

        foreach ($nameIdeas as $nameIdea) {
            if (NameIdea::where('name', $nameIdea->name)->count() > 0) {
                continue;
            }
            $nameIdea->save();
            $nameIdea->namePattern()->save(
                NamePattern::create([
                    'name' => $nameIdea->name,
                ])
            );
        }
    }
}
