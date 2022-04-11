<?php

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            [
                'title' => 'Odamax',
                'slug' => 'odamax',
                'api_url' => 'https://www.odamax.com/tr/',
                'domain' => 'odamax.com',
                'image' => 'odamax.png',
                'user' => [
                    'name' => 'Odamax',
                    'email' => 'odamax@admin.com',
                    'password' => Hash::make('141277kk'),
                    'is_active' => 1,
                    'is_admin' => 1,
                ]
            ],
            [
                'title' => 'Hotels.com',
                'slug' => 'hotels.com',
                'api_url' => 'https://tr.hotels.com/',
                'domain' => 'hotels.com',
                'image' => 'hotels-com.png',
                'user' => [
                    'name' => 'Hotels',
                    'email' => 'hotels@admin.com',
                    'password' => Hash::make('141277kk'),
                    'is_active' => 1,
                    'is_admin' => 1,
                ]
            ],
            [
                'title' => 'tatil.com',
                'slug' => 'tatil.com',
                'api_url' => 'https://www.tatil.com/',
                'domain' => 'tatil.com',
                'image' => 'tatil-com.webp',
                'user' => [
                    'name' => 'Tatil',
                    'email' => 'info@tatil.com',
                    'password' => Hash::make('141277kk'),
                    'is_active' => 1,
                    'is_admin' => 1,
                ]
            ],
            [
                'title' => 'trip.com',
                'slug' => 'trip-com',
                'image' => 'trip-com.png',
                'api_url' => 'https://tr.trip.com/?locale=tr_tr/',
                'domain' => 'trip.com',
                'user' => [
                    'name' => 'TripCom',
                    'email' => 'info@trip.com',
                    'password' => Hash::make('141277kk'),
                    'is_active' => 1,
                    'is_admin' => 1,
                ]
            ],
        ];

        foreach ($companies as $company) {
            $user = \App\User::updateOrCreate(
                ['email' => $company['user']['email']],
                $company['user']
            );
            $user['role_id'] = \App\Models\Auth\Role::ROLE_COMPANY;
            unset($company['user']);
            $company['user_id'] = $user->id;


            $imageFile = file_get_contents(public_path('site/company/minify/' . $company['image']));
            Storage::put('public/company/' . $company['image'], $imageFile);

            \App\Models\Product\UrunFirma::updateOrCreate(
                ['title' => $company['title']],
                $company
            );
        }
    }
}
