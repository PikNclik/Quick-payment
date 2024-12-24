<?php

namespace Database\Seeders;

use App\Models\BusinessDomain;
use App\Models\BusinessType;
use App\Models\Profession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ProfessionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // delete old data
        Schema::disableForeignKeyConstraints();
        BusinessType::truncate();
        Schema::enableForeignKeyConstraints();
        $handle = fopen("database/seeders/professions.csv", "r");
        for ($i = 0; $row = fgetcsv($handle ); ++$i) {
           $bs = BusinessType::firstOrCreate(['name'=>$row[0]]);
           $bd = BusinessDomain::firstOrCreate(['name'=>$row[1],'business_type_id'=>$bs->id]);
           $profession = Profession::firstOrCreate(['name'=>$row[2],'business_domain_id'=>$bd->id]);
        }
        fclose($handle);


    }
}
