<?php

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->packages() as $package) {
            $packageDB = Package::updateOrCreate([
                'slug' => $package['slug']
            ], $package);

        }
    }

    private function packages()
    {
        return [
            [
                'title' => 'Aylık',
                'slug' => 'aylik',
                'price' => 49,
                'description' => "1 Aylık Sınırsız ilan ekleme özelliği",
                'day' => 30
            ],
            [
                'title' => '3 Aylık',
                'slug' => '3-aylik',
                'price' => 119,
                'description' => "3 Aylık Sınırsız ilan ekleme özelliği",
                'day' => 90
            ],
            [
                'title' => '6 Aylık',
                'slug' => '6-aylik',
                'price' => 169,
                'description' => "6 Aylık Sınırsız ilan ekleme özelliği",
                'day' => 180
            ],
            [
                'title' => '12 Aylık',
                'slug' => '12-aylik',
                'price' => 199,
                'description' => "12 Aylık Sınırsız ilan ekleme özelliği",
                'day' => 360
            ]
        ];
    }
}
