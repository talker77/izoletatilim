<?php

use Illuminate\Database\Seeder;

class PackageUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stores = \App\User::where('role_id', \App\Models\Auth\Role::ROLE_STORE)->get();


        foreach ($stores as $storeUser) {
            $startDate = \Carbon\Carbon::now()->addDays(random_int(0, 4));

            $package = \App\Models\Package::inRandomOrder()->first();


            \App\Models\PackageUser::create([
                'user_id' => $storeUser->id,
                'started_at' => $startDate,
                'expired_at' => $startDate->copy()->addDays($package->day),
                'price' => $package->price,
                'is_payment' => true,
                'package_id' => $package->id,
                'invoice_address_id' => $storeUser->invoice_addresses()->first()->id
            ]);
        }
    }
}
