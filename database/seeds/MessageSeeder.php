<?php

use App\Models\Message;
use App\User;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        for ($i = 0; $i < 250; $i++) {
            $from = User::inRandomOrder()->first();
            $to = User::inRandomOrder()->first();
            if ($from->id == $to->id) {
                $to = User::inRandomOrder()->where('id', '!=', $from->id)->first();
            }
            Message::create([
                'from_id' => $from->id,
                'to_id' => $to->id,
                'message' => $faker->realText(250),
            ]);
        }
    }
}
