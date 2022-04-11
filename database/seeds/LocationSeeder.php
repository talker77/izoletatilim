<?php

use App\Models\Region\District;
use App\Models\Region\Location;
use App\Models\Region\State;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param \Faker\Generator $faker
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        Location::truncate();
        $locations = [
            [
                'title' => 'Erciyes Kayak Merkezi',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'state_id' => State::first()->id,
                'status' => 1,
                'type_id' => \App\Models\LocationType::first()->id,
            ],
            [
                'title' => 'Botanik Bahçe Kuzguncuk',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'state_id' => State::where('title', "İstanbul")->first()->id,
                'district_id' => District::where('title', "Üsküdar")->first()->id,
                'status' => 1,
                'type_id' => \App\Models\LocationType::where('title', "Botanik Bahçe")->first()->id
            ],
            [
                'title' => 'Kleopatra Plajı',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'state_id' => State::where('title', "Antalya")->first()->id,
                'district_id' => District::where('title', "Alanya")->first()->id,
                'status' => 1,
                'type_id' => \App\Models\LocationType::where('title', "Plaj")->first()->id
            ],
            [
                'title' => 'Alanya Kalesi',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'state_id' => State::where('title', "Antalya")->first()->id,
                'district_id' => District::where('title', "Alanya")->first()->id,
                'status' => 1,
                'type_id' => \App\Models\LocationType::where('title', "Kale")->first()->id
            ],
            [
                'title' => 'Sultan Ahmet Camii',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'state_id' => State::where('title', "İstanbul")->first()->id,
                'district_id' => District::where('title', "Fatih")->first()->id,
                'status' => 1,
                'type_id' => \App\Models\LocationType::where('title', "Cami")->first()->id
            ],
            [
                'title' => 'Galata Kulesi',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'state_id' => State::where('title', "İstanbul")->first()->id,
                'district_id' => District::where('title', "Beyoğlu")->first()->id,
                'status' => 1,
                'type_id' => \App\Models\LocationType::where('title', "Kale")->first()->id
            ],
            [
                'title' => 'Düden Şelalesi',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'state_id' => State::where('title', "Antalya")->first()->id,
                'district_id' => District::where('title', "Kepez")->first()->id,
                'status' => 1,
                'type_id' => \App\Models\LocationType::where('title', "Kale")->first()->id
            ],
            [
                'title' => 'Kaputaş Plajı',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'state_id' => State::where('title', "Antalya")->first()->id,
                'district_id' => District::where('title', "Kaş")->first()->id,
                'status' => 1,
                'type_id' => \App\Models\LocationType::where('title', "Plaj")->first()->id
            ],
            [
                'title' => 'Eğirdir Gölü',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'state_id' => State::where('title', "Isparta")->first()->id,
                'district_id' => District::where('title', "Eğirdir")->first()->id,
                'status' => 1,
                'type_id' => \App\Models\LocationType::where('title', "Göl")->first()->id
            ],
            [
                'title' => 'Salda Gölü',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'state_id' => State::where('title', "Burdur")->first()->id,
                'district_id' => District::where('title', "Yeşilova")->first()->id,
                'status' => 1,
                'type_id' => \App\Models\LocationType::where('title', "Göl")->first()->id
            ],
            [
                'title' => 'Efes Antik Kenti',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'state_id' => State::where('title', "İzmir")->first()->id,
                'district_id' => District::where('title', "Selçuk")->first()->id,
                'status' => 1,
                'type_id' => \App\Models\LocationType::where('title', "Kale")->first()->id
            ],
            [
                'title' => 'Bodrum Kalesi',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'state_id' => State::where('title', "Muğla")->first()->id,
                'district_id' => District::where('title', "Bodrum")->first()->id,
                'status' => 1,
                'type_id' => \App\Models\LocationType::where('title', "Kale")->first()->id
            ],


        ];
        foreach ($locations as $location) {
            $location['slug'] = \Illuminate\Support\Str::slug($location['title']);
            $imageName = $location['slug'] . '.jpg';
            $imageFile = file_get_contents("https://picsum.photos/370/190");
            Storage::put('public/locations/' . $imageName, $imageFile);
            $location['image'] = $imageName;
            $location['description'] = $faker->realText(240);

            Location::create($location);
        }

    }
}
