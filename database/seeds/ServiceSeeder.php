<?php

use App\Models\Region\Country;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        for ($i = 0; $i < 50; $i++) {

            $title = implode(" ", $faker->words());
            $slug = \Illuminate\Support\Str::slug($title);
            $country = Country::where('title', 'Turkey')->first();
            $state = $country->states()->inRandomOrder()->first();
            $district = $state->districts()->inRandomOrder()->first();
            $user = \App\User::inRandomOrder()->where('role_id',\App\Models\Auth\Role::ROLE_STORE)->first();

            $imageName = $slug . '.jpg';
            $imageFile = file_get_contents("https://picsum.photos/900/500");
            Storage::put('public/services/' . $imageName, $imageFile);
            Storage::put('public/services/thumb/' . $imageName, $imageFile);
            $service = Service::create([
                'title' => $title,
                'slug' => $slug,
                'point' => $faker->numberBetween(0, 5),
                'country_id' => $country->id,
                'state_id' => $state->id,
                'district_id' => $district ? $district->id : null,
                'address' => $faker->address,
                'image' => $imageName,
                'short_description' => $faker->text(255),
                'description' => $faker->text(255),
                'store_type' => $i > 35 ? Service::STORE_TYPE_LOCAL : Service::STORE_TYPE_LOCAL,
                'user_id' => $user->id,
//                'redirect_to' => $faker->url,
                'type_id' => ServiceType::inRandomOrder()->first()->id,
                'lat' => $faker->latitude,
                'long' => $faker->longitude,
                'person' => $faker->numberBetween(1,10),
                'status' => Service::STATUS_PUBLISHED
            ]);

            $service->attributes()->sync(
                \App\Models\ServiceAttribute::inRandomOrder()->take(3)->get()->pluck('id')
            );
        }

    }
}
