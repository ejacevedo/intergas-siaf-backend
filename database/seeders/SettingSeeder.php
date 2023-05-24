<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;


class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'price_sale' =>  0.66667,
            'price_kilogram' => 38000.00,
            'price_liter' => 76000.00,
            'price_disel' => 24.20,
            'price_event' => 3.20,
        ]);
    }
}
