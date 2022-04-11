<?php

use App\Models\Service;
use App\Models\ServiceAppointment;
use Illuminate\Database\Seeder;

class ServiceAppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        $services = Service::where('store_type', Service::STORE_TYPE_LOCAL)->get();
        foreach ($services as $service) {
            $startDate = \Carbon\Carbon::now()->addDays(random_int(0, 4));
            $endDate = \Carbon\Carbon::now()->addDays(random_int(5, 15));
            for ($i = 0; $i < 5; $i++) {
                $hasAppointment = ServiceAppointment::where(['service_id' => $service->id])
                    ->where(function ($query) use ($startDate, $endDate) {
                        $query->whereDate('start_date', '>=', $startDate)
                            ->orWhereDate('end_date', '<=', $endDate);
                    })
                    ->first();

                if (!$hasAppointment) {
                    ServiceAppointment::create([
                        'service_id' => $service->id,
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'price' => $faker->randomFloat(2, 0, 1000)
                    ]);
                }

            }
        }

    }
}
