<?php

use App\Models\PackageCompany;
use App\Models\Product\UrunFirma;
use Illuminate\Database\Seeder;

class PackageCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = UrunFirma::all();


        foreach ($companies as $company) {
            $startDate = \Carbon\Carbon::now()->addDays(random_int(0, 4));

            $package = \App\Models\Package::inRandomOrder()->first();


            PackageCompany::create([
                'company_id' => $company->id,
                'started_at' => $startDate,
                'expired_at' => $startDate->copy()->addDays($package->day),
                'price' => $package->price,
                'is_payment' => true,
                'package_id' => $package->id
            ]);
        }
    }
}
