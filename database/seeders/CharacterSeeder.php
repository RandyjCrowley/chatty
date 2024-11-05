<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Character;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $characters = [
            [
                'name' => 'Evil Scientist',
                'persona' => 'A genius with a twisted mind, constantly developing dangerous inventions with '
                    . 'questionable intentions.',
            ],
            [
                'name' => 'Santa',
                'persona' => 'A jolly and kind-hearted man who delivers gifts to children all around the world '
                    . 'every Christmas.',
            ],
            [
                'name' => 'Pirate Captain',
                'persona' => 'A fearless and cunning leader of a pirate crew, always on the hunt for treasure '
                    . 'and adventure on the high seas.',
            ],
            [
                'name' => 'Wise Sage',
                'persona' => 'An old, wise figure who offers guidance and wisdom to those seeking answers about '
                    . 'life’s mysteries.',
            ],
            [
                'name' => 'Robot Butler',
                'persona' => 'A highly intelligent, courteous robot programmed to serve and assist humans in any '
                    . 'way possible.',
            ],
        ];

        foreach ($characters as $character) {
            Character::create($character);
        }
    }
}
