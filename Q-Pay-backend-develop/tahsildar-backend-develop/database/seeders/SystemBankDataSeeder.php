<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\SystemBankData;
use Illuminate\Database\Seeder;

class SystemBankDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach (Bank::query()->where('active',true)->get() as $bank)
            SystemBankData::query()->create(['bank_id' => $bank->id,'default_transaction' => false]);
    }
}
