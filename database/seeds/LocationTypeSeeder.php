<?php

use Illuminate\Database\Seeder;

class LocationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\LocationType::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $types = [
          ['title' => 'Kayak Merkezi'],
          ['title' => 'Gar'],
          ['title' => 'Botanik Bahçe'],
          ['title' => 'Sahil'],
          ['title' => 'Liman'],
          ['title' => 'AVM'],
          ['title' => 'Shopping Cart'],
          ['title' => 'Anıt/Memorial'],
          ['title' => 'Kale'],
          ['title' => 'Plaj'],
          ['title' => 'Cami'],
          ['title' => 'Göl'],
        ];

        foreach ($types as $type){
            \App\Models\LocationType::create($type);
        }
    }
}
