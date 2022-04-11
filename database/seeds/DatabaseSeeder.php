<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(KategorilerTableSeeder::class);
//        $this->call(UrunlerTableSeeder::class);
//        $this->call(UrunAttributeTableSeeder::class);



        $this->call(RolesTableSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(AyarlarTableSeeder::class);
        $this->call(RegionSeeder::class);
        $this->call(CityTownTableSeeder::class);
        $this->call(LocationTypeSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(ServiceTypeSeeder::class);
        $this->call(ServiceAttributeSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(ServiceCompanySeeder::class);
        $this->call(ServiceCommentSeeder::class);
        $this->call(AppointmentSeeder::class);
        $this->call(ServiceAppointmentSeeder::class);
        $this->call(ServiceCompanyCommentSeeder::class);
        $this->call(ServiceReservationSeeder::class);
        $this->call(FavoriteSeeder::class);
        $this->call(MessageSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(PackageUserSeeder::class);



//        $this->call(CargoSeeder::class);
//        $this->call(AddressSeeder::class);
    }
}
