<?php

use App\Models\Service;
use App\Models\ServiceComment;
use App\User;
use Illuminate\Database\Seeder;

class ServiceCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        ServiceComment::truncate();
        for ($i = 0; $i < 150; $i++) {
            $service = Service::inRandomOrder()->first();
            $user = User::inRandomOrder()->where(['role_id' => \App\Models\Auth\Role::ROLE_CUSTOMER])->first();
            ServiceComment::create([
                'service_id' => $service->id,
                'user_id' => $user->id,
                'message' => $faker->realText(255),
                'point' => random_int(1, 10),
                'status' => 1
            ]);
            $service->update([
                'point' => ServiceComment::where('service_id', $service->id)->avg('point')
            ]);
        }

    }
}
