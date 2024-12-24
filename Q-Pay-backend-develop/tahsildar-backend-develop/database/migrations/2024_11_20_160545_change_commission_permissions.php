<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissions')->where('category_id',9)->delete();
        DB::table('permission_category')->where('id',9)->delete();
        DB::table('permission_category')->where('id',9)->delete();
        DB::table('permissions')
        ->insert([
            [
                'id' => 26,
                'name' => 'Edit Internal Commission',
                'text_to_show' => 'Edit Internal Commission',
                'category_id' => 4
            ],
            [
                'id' => 27,
                'name' => 'Edit External Commission',
                'text_to_show' => 'Edit External Commission',
                'category_id' => 4
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
