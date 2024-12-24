<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class CommissionSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Setting::query()->create([
           'key' => 'fees_fixed',
           'value' => '0'
        ]);
        Setting::query()->create([
            'key' => 'commission_fixed',
            'value' => '0'
        ]);
        Setting::query()->create([
            'key' => 'commission_percentage',
            'value' => '0'
        ]);
        Setting::query()->create([
            'key' => 'active_commission',
            'value' => '0'
        ]);
        Setting::query()->create([
            'key' => 'direct_commission',
            'value' => '0'
        ]);
        Setting::query()->create([
            'key' => 'qpay_fees_account',
            'value' => '0'
        ]);
        Setting::query()->create([
            'key' => 'qpay_commission_account',
            'value' => '0'
        ]);

    }
}
