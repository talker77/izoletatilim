<?php

use App\Models\KullaniciAdres;
use App\Models\Region\Country;
use App\Models\Region\State;
use App\User;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::where('role_id', \App\Models\Auth\Role::ROLE_STORE)->first();

        $state = State::where('title','İSTANBUL')->first();
        $address = $user->addresses()->create([
            'country_id' => Country::where('title','Turkey')->first()->id,
            'state_id' => $state->id,
            'district_id' => $state->districts()->inRandomOrder()->first()->id,
            'title' => 'Evim',
            'name' => 'Murat',
            'surname' => 'Karabacak',
            'phone' => "512307124",
            'type' => KullaniciAdres::TYPE_DELIVERY,
            'adres' => 'Can sk. Kuzey Apt. No:32 D:6'
        ]);

        $state = State::where('title','İSTANBUL')->first();
        $invoiceAddresses = $user->addresses()->create([
            'country_id' => Country::where('title','Turkey')->first()->id,
            'state_id' => $state->id,
            'district_id' => $state->districts()->inRandomOrder()->first()->id,
            'title' => 'İş Adresim',
            'name' => 'Murat',
            'surname' => 'Karabacak',
            'phone' => "512309237",
            'type' => KullaniciAdres::TYPE_INVOICE,
            'adres' => 'Ordu Sk. Veysel Apt No :20 D:4'
        ]);

        $user->update([
            'default_invoice_address_id' => $invoiceAddresses->id,
            'default_address_id' => $address->id
        ]);
    }
}
