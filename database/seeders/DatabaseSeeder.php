<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('oauth_clients')->count() < 1) {
            Artisan::call('passport:install');
        }
        \App\Models\User::factory(1)->create();
        \App\Models\Spaceship::factory(5)->create()->each(function($spaceship) {
            $spaceship->armaments()->saveMany(
                \App\Models\Armament::factory(3)->make(['spaceship_id' => NULL])
            );
        });
    }
}
