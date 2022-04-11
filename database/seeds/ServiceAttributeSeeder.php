<?php

use Illuminate\Database\Seeder;

class ServiceAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes = [
            ['title' => 'Wifi', 'icon' => 'soap-icon-wifi circle', 'show_menu' => true],
            ['title' => 'Mutfak', 'icon' => 'soap-icon-fork circle', 'show_menu' => true],
            ['title' => 'Klima', 'icon' => 'soap-icon-aircon circle', 'show_menu' => true],
            ['title' => 'Otopark', 'icon' => 'soap-icon-car circle', 'show_menu' => true],
            ['title' => 'Balkon / Teras', 'icon' => 'soap-icon-fireplace circle', 'show_menu' => true],
            ['title' => 'Çamaşır Makinesi'],
            ['title' => 'Tv / Eğlence', 'icon' => 'soap-icon-television circle', 'show_menu' => true],
            ['title' => 'Saç Kurutma Makinesi'],
            ['title' => 'Havuz', 'icon' => 'soap-icon-swimming circle', 'show_menu' => true],
            ['title' => 'Sigara İçilmeyen Alan', 'icon' => 'soap-icon-smoking circle', 'show_menu' => true],
            ['title' => 'Restoran', 'icon' => 'soap-icon-food circle', 'show_menu' => true],
            ['title' => 'Otelde Öde'],
            ['title' => 'Spa'],
            ['title' => 'Ücretsiz İptal', 'icon' => 'soap-icon-calendar-check circle', 'show_menu' => true],
            ['title' => 'Aileler', 'icon' => 'soap-icon-family circle', 'show_menu' => true],
            ['title' => 'Su Masajı Kuveti'],
        ];
        foreach ($attributes as $attribute) {
            \App\Models\ServiceAttribute::updateOrCreate([
                'title' => $attribute['title']
            ], array_merge($attribute, [
                'type_id' => \App\Models\ServiceType::inRandomOrder()->first()->id
            ]));
        }
    }
}
