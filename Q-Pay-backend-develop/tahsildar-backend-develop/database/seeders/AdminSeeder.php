<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin = Admin::query()->create(
            [
                'username' => 'super_admin',
                'password' => Hash::make('^4i3a@O2{Qkj')
            ]
        );
        $super_admin->createToken('user-auth-token', ['super_admin','admin']);

        $admin = Admin::query()->create(
            [
                'username' => 'admin',
                'password' => Hash::make('^4i3a@O2{Qkj')
            ]
        );
        $admin->createToken('user-auth-token', ['admin']);
    }
}
