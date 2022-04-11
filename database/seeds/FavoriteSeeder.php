<?php

use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\App\User::all() as $user) {
            $services = \App\Models\Service::inRandomOrder()->take(6)->get();
            foreach ($services as $service) {
                \App\Models\Favori::create(['service_id' => $service->id, 'user_id' => $user->id]);
            }
        }
    }
}
