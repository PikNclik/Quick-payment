<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            [
                'en' => ['name' => 'Damascus'],
                'ar' => ['name' => 'دمشق'],
            ],
            [
                'en' => ['name' => 'Rief Dimashq'],
                'ar' => ['name' => 'ريف دمشق'],
            ],
            [
                'en' => ['name' => 'Aleppo'],
                'ar' => ['name' => 'حلب'],
            ],
            [
                'en' => ['name' => 'Homs'],
                'ar' => ['name' => 'حمص'],
            ],
            [
                'en' => ['name' => 'Hama'],
                'ar' => ['name' => 'حماة'],
            ],
            [
                'en' => ['name' => 'Tartus'],
                'ar' => ['name' => 'طرطوس'],
            ],
            [
                'en' => ['name' => 'Latakia'],
                'ar' => ['name' => 'اللاذقية'],
            ],
            [
                'en' => ['name' => 'Qunaitera'],
                'ar' => ['name' => 'القنيطرة'],
            ],
            [
                'en' => ['name' => 'Daraa'],
                'ar' => ['name' => 'درعا'],
            ],
            [
                'en' => ['name' => 'dier alzour'],
                'ar' => ['name' => 'دير الزور'],
            ],
            [
                'en' => ['name' => 'Alhasaka'],
                'ar' => ['name' => 'الحسكة'],
            ],
            [
                'en' => ['name' => 'Idleb'],
                'ar' => ['name' => 'ادلب'],
            ],
        ];

        foreach ($cities as $city)
        {
            City::query()->create($city);
        }
    }
}
