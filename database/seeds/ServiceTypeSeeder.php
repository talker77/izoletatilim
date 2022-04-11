<?php

use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['title' => 'Villa / Müstakil Ev'],
            ['title' => 'Bungalov'],
            ['title' => 'Dağ Evi'],
            ['title' => 'Tekne'],
            ['title' => 'Karavan'],
//            ['title' => 'Ev/Apart Daire'],
//            ['title' => 'Pansiyon', 'parent' => 1],
//            ['title' => 'Oda & Kahvaltı', 'parent' => 1],
//            ['title' => 'Apart Daire', 'parent' => 1],
//            ['title' => 'Karavan'],
        ];
        foreach ($types as $type) {
            $parentId = null;
            if (isset($type['parent'])) {
                $parentId = ServiceType::where('title', $types[$type['parent']]['title'])->first()->id;
            }

            ServiceType::updateOrCreate([
                'title' => $type['title']
            ], [
                'title' => $type['title'],
                'slug' => \Illuminate\Support\Str::slug($type['title']),
                'parent_id' => $parentId,
            ]);
        }
    }
}
