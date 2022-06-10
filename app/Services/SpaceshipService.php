<?php

namespace App\Services;

use App\Models\Spaceship;
use App\Models\Armament;

class SpaceshipService
{
    /**
     * Store spaceship data in db.
     *
     * @param  array  $spaceshipData
     * @return \App\Models\Spaceship
     */
    public function createSpaceship(array $spaceshipData): Spaceship
    {
        $spaceship = Spaceship::create([
            'name' => $spaceshipData['name'],
            'class' => $spaceshipData['class'],
            'crew' => $spaceshipData['crew'],
            'image' => $spaceshipData['image'],
            'value' => $spaceshipData['value'],
            'status' => $spaceshipData['status'],
        ]);

        foreach ($spaceshipData['armament'] as $value) {
            $spaceship->armaments()->create([
                'title' => $value['title'],
                'qty' => $value['qty'],
            ]);
        }

        return $spaceship;
    }

    /**
     * Update spaceship data in db.
     *
     * @param  array  $spaceshipData
     * @return \App\Models\Spaceship
     */
    public function updateSpaceship(array $spaceshipData): Spaceship
    {
        $spaceship = Spaceship::create([
            'name' => $spaceshipData['name'],
            'class' => $spaceshipData['class'],
            'crew' => $spaceshipData['crew'],
            'image' => $spaceshipData['image'],
            'value' => $spaceshipData['value'],
            'status' => $spaceshipData['status'],
        ]);

        return $spaceship;
    }
}
