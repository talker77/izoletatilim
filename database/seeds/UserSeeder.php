<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        User::create([
            'name' => "zafer",
            'surname' => "Yalçın",
            'email' => config('admin.username'),
            'password' => Hash::make(config('admin.password')),
            'is_active' => 1,
            'role_id' => \App\Models\Auth\Role::where('name', 'super-admin')->first()->id,
            'is_admin' => 1,
        ]);

        User::create([
            'name' => "Ali",
            'surname' => "CemKaya",
            'email' => config('admin.store_email'),
            'password' => Hash::make(config('admin.store_password')),
            'is_active' => 1,
            'role_id' => \App\Models\Auth\Role::ROLE_STORE,
            'is_admin' => 1,
        ]);


        User::create([
            'name' => "Mehmet",
            'surname' => "Müşteri v2",
            'email' => "customer@admin.com",
            'password' => Hash::make(config('admin.customer_password')),
            'is_active' => 1,
            'role_id' => \App\Models\Auth\Role::ROLE_CUSTOMER,
            'is_admin' => 1,
        ]);
    }
}
