<?php

use App\Models\Country;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insertCountries();
        foreach ($this->turkeyRegions() as $region) {
            \App\Models\Region\Region::updateOrCreate([
                'title' => $region['title']
            ], [
                'status' => 1,
                'country_id' => \App\Models\Region\Country::TURKEY
            ]);
        }
    }

    private function insertCountries()
    {
        $countryJson = json_decode(file_get_contents(database_path('seeds/files/countries.json'), true));
        foreach ($countryJson as $country) {
            $country = (array)$country;
            Country::firstOrCreate([
                'title' => $country['Name'],
                'code' => $country['Code'],
            ]);
        }
    }

    private function turkeyRegions()
    {
        return [
            [
                'title' => 'AKDENİZ',
            ],
            [
                'title' => 'DOĞU ANADOLU',
            ],
            [
                'title' => 'EGE',
            ],
            [
                'title' => 'GÜNEYDOĞU ANADOLU',
            ],
            [
                'title' => 'İÇ ANADOLU',
            ],
            [
                'title' => 'MARMARA',
            ],
            [
                'title' => 'KARADENİZ',
            ]
        ];
    }
}
