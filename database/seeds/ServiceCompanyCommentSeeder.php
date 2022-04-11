<?php

use App\Models\Service;
use App\Models\ServiceCompany;
use App\Models\ServiceCompanyComment;
use Illuminate\Database\Seeder;

class ServiceCompanyCommentSeeder extends Seeder
{
    public function run(\Faker\Generator $faker)
    {
        ServiceCompanyComment::truncate();
        foreach (ServiceCompany::all() as $serviceCompany) {
//dd($serviceCompany->service()->avg('point'));
            for ($i = 0; $i < random_int(2, 5); $i++) {
                ServiceCompanyComment::create([
                    'full_name' => $faker->name,
                    'message' => $faker->realText(255),
                    'point' => random_int(1, 10),
                    'status' => 1,
                    'service_company_id' => $serviceCompany->id,
                    'service_id' => $serviceCompany->service_id
                ]);
            }

            Service::find($serviceCompany->service_id)->update([
               'point' => ServiceCompanyComment::where('service_id',$serviceCompany->service_id)->avg('point')
            ]);

        }
    }
}
