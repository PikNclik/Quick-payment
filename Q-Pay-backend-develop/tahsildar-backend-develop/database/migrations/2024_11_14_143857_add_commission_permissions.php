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
        DB::table('permission_category')
        ->insert([
            [
                'id' => 9,
                'name' => 'Commission',
                'text_to_show' => 'Commission'
            ]

        ]);
        DB::table('permissions')
        ->insert([
            [
                'id' => 26,
                'name' => 'View',
                'text_to_show' => 'View',
                'category_id' => 9
            ],
            [
                'id' => 27,
                'name' => 'Add',
                'text_to_show' => 'Add',
                'category_id' => 9
            ],
            [
                'id' => 28,
                'name' => 'Edit',
                'text_to_show' => 'Edit',
                'category_id' => 9
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
