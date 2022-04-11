<?php


use App\Models\Region\Country;
use Illuminate\Database\Seeder;

class CityTownTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $turkey = Country::where('title', "Turkey")->first();
        $germany = Country::where('title', "Germany")->first();

        // turkey city inserts
        $this->insertTurkeyCities($turkey);
//        $this->insertGermanyCountries($germany);


    }



    private function insertTurkeyCities(Country $turkey)
    {
        $turkeyCities = json_decode(file_get_contents(database_path('seeds/files/turkey-bolge-il-ilce.json')), true);
        foreach ($turkeyCities as $state) {
            $stateModel = $turkey->states()->updateOrCreate(['title' => $state['il']], [
                'region_id' => \App\Models\Region\Region::where('title', $state['bolge'])->first()->id
            ]);
            $stateModel->districts()->firstOrCreate(['title' => $state['ilce']]);
        }
    }

    /**
     * @param Country $germany
     */
    private function insertGermanyCountries(Country $germany)
    {
        $germanyCountries = json_decode(file_get_contents(database_path('seeds/files/germany_cities.json')), true);
        foreach ($germanyCountries as $item) {
            $stateModel = $germany->states()->firstOrCreate(['title' => $item['state']]);
            if (isset($item['district'])) {
                $districtModel = $stateModel->districts()->firstOrCreate(['title' => $item['district']]);
                $districtModel->neighborhoods()->firstOrCreate(['title' => $item['name']]);
            } else {
                $stateModel->districts()->firstOrCreate(['title' => $item['name']]);
            }
        }
    }
}
