<?php

use Illuminate\Database\Seeder;
use  App\Models\Ayar;

class AyarlarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config = [
            'title' => 'İzole Tatil',
            'desc' => 'site default açıklama',
            'domain' => 'http://izoletatilim.com',
            'logo' => 'logo.png',
            'footer_logo' => 'footer_logo.png',
            'icon' => 'icon.png',
            'keywords' => 'kelime,ornek,default',
            'footer_text' => 'footer örnek yazı',
            'mail' => 'ornek@mail.com',
            'adres' => 'örnek adres bilgileri',
            'active' => 1,
            'lang' => config('admin.default_language')
        ];

        foreach (Ayar::activeLanguages() as $language) {
            $newConfig = $config;
            $newConfig['lang'] = $language[0];
            $newConfig['cargo_price'] = random_int(1, 5) * 10;
            $newConfig['title'] = $config['title'];
            $data = Ayar::create($newConfig);
            Ayar::setCache($data, $language[0]);
        }

    }
}
