<?php

use App\Models\Appointment;
use App\Models\ServiceCompany;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        Appointment::truncate();
        for ($i = 0; $i < 400; $i++) {
            $serviceCompany = ServiceCompany::inRandomOrder()->first();
            $startDate = \Carbon\Carbon::now()->addDays(random_int(0, 4));
            $endDate = \Carbon\Carbon::now()->addDays(random_int(5, 15));

            $hasAppointment = Appointment::where(['service_company_id' => $serviceCompany->id])
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('start_date', '>=', $startDate)
                        ->orWhereDate('end_date', '<=', $endDate);
                })
                ->first();

            if (!$hasAppointment) {
                \App\Models\Appointment::create([
                    'service_company_id' => $serviceCompany->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'price' => $faker->randomFloat(2, 0, 1000)
                ]);
            }
        }

    }
}
