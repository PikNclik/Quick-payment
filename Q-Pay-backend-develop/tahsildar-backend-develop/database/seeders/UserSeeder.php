<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create(
            [
                'full_name' => 'ghassan Mg',
                'active' => 1,
                'phone' => '+963993522958',
                'verification_code' => null,
                'bank_id' => 1,
                'bank_account_number' => 122,
                'city_id' => 1
            ]
        );
    }
}
