<?php

use Illuminate\Database\Seeder;

class ServiceReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker\Generator $faker)
    {
        for ($i = 0; $i < 100; $i++) {
            $service = \App\Models\Service::inRandomOrder()->first();
            $startDate = \Carbon\Carbon::now()->addDays(random_int(0, 4));
            $endDate = \Carbon\Carbon::now()->addDays(random_int(5, 15));
            $user = \App\User::where(['role_id' => \App\Models\Auth\Role::ROLE_CUSTOMER])->inRandomOrder()->first();

            $hasReservation = \App\Models\Reservation::where(['service_id' => $service->id])
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('start_date', '>=', $startDate)
                        ->orWhereDate('end_date', '<=', $endDate);
                })
                ->first();

            if (!$hasReservation) {
                $price = $faker->randomFloat(2, 0, 1000);
                $day = $startDate->diffInDays($endDate);

                \App\Models\Reservation::create([
                    'service_id' => $service->id,
                    'user_id' => $user->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'price' => $price,
                    'total_price' => $price * $day,
                    'status' => random_int(1,6),
                ]);
            }
        }
    }
}
