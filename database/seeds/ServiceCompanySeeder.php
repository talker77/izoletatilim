<?php

use App\Models\Product\UrunFirma;
use App\Models\Service;
use App\Models\ServiceCompany;
use Illuminate\Database\Seeder;

class ServiceCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param \Faker\Generator $faker
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        for ($i = 0; $i < 50; $i++) {
            $service = Service::inRandomOrder()->first();
            $company = UrunFirma::inRandomOrder()->first();
            $title = $service->title . ' ' . $faker->word;
            ServiceCompany::create([
                'title' => $title,
                'slug' => \Illuminate\Support\Str::slug($title),
                'redirect_to' => $faker->url,
                'service_id' => $service->id,
                'company_id' =>  $company->id,
            ]);
        }

    }
}
