<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = [
            ['id' => 1, 'name_ar' => 'المصرف التجاري السوري', 'name_en' => 'Syrian Commercial Bank'],
            ['id' => 2, 'name_ar' => 'المصرف الصناعي', 'name_en' => 'Industrial Bank'],
            ['id' => 3, 'name_ar' => 'المصرف الز ارعي التعاوني', 'name_en' => 'Agricultural Cooperative Bank'],
            ['id' => 4, 'name_ar' => ' مصرف التسليف الشعبي', 'name_en' => 'Popular Credit Bank'],
            ['id' => 5, 'name_ar' => 'المصرف العقاري', 'name_en' => 'Real Estate Bank'],
            ['id' => 6, 'name_ar' => 'مصرف التوفير', 'name_en' => 'Savings Bank'],
            ['id' => 8, 'name_ar' => 'بنك بيمو السعودي الفرنسي', 'name_en' => 'Banque Bemo Saudi Fransi'],
            ['id' => 9, 'name_ar' => 'بنك سورية و المهجر', 'name_en' => 'Bank of Syria and Overseas'],
            ['id' => 10, 'name_ar' => 'المصرف الدولي للتجارة والتمويل', 'name_en' => 'International Bank for Trade and Finance'],
            ['id' => 11, 'name_ar' => 'البنك العربي - سورية', 'name_en' => 'Arab Bank - Syria S.A'],
            ['id' => 12, 'name_ar' => 'بنك اإلئتمان األهلي أي تي بي', 'name_en' => 'Ahli Trust Bank'],
            ['id' => 13, 'name_ar' => 'بنك بيبلوس - سورية', 'name_en' => 'Byblos Bank Syria S.A'],
            ['id' => 14, 'name_ar' => 'بنك سورية و الخليج', 'name_en' => 'Syria Gulf Bank','active' => true],
            ['id' => 15, 'name_ar' => 'بنك الشام', 'name_en' => 'Cham Bank','active' => true],
            ['id' => 16, 'name_ar' => 'بنك سورية الدولي الإسلامي', 'name_en' => 'Syrian International Islamic Bank','active' => true],
            ['id' => 17, 'name_ar' => 'بنك الأردن -سورية', 'name_en' => 'Jordan Bank'],
            ['id' => 18, 'name_ar' => 'بنك فرنسبنك -سورية', 'name_en' => 'Societe Generale Bank - Syria'],
            ['id' => 19, 'name_ar' => 'بنك الشرق', 'name_en' => 'AlSharq Bank'],
            ['id' => 20, 'name_ar' => 'بنك قطر الوطني ـ سورية', 'name_en' => 'Qatar National Bank - Syria SA'],
            ['id' => 21, 'name_ar' => 'بنك البركة سورية', 'name_en' => 'Al Baraka Bank','active' => true],
            ['id' => 22, 'name_ar' => 'البنك الوطني اإلسالمي', 'name_en' => 'National Islamic Bank']
        ];

        foreach ($banks as $bank)
            Bank::query()->create([
                'id' => $bank['id'],
                'en' => ['name' => $bank['name_en']],
                'ar' => ['name' => $bank['name_ar']],
                'active' => isset($bank['active']) ? $bank['active'] : false
            ]);
    }
}
