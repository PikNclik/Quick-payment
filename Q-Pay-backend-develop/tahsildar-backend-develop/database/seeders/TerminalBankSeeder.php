<?php

namespace Database\Seeders;

use App\Definitions\PaymentTypeEnums;
use App\Models\SystemBankData;
use App\Models\TerminalBank;
use Illuminate\Database\Seeder;

class TerminalBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $system_bank = SystemBankData::query()->limit(2)->get()->toArray();
        TerminalBank::query()->create([
            'terminal' => '10000',
            'payment_gateway' => PaymentTypeEnums::PAYMENT,
           'system_bank_data_id' => $system_bank[0]['id']
        ]);

        TerminalBank::query()->create([
            'terminal' => '20000',
            'payment_gateway' => PaymentTypeEnums::TRANSFER,
            'system_bank_data_id' => $system_bank[1]['id']
        ]);
    }
}
