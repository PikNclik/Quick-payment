<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('permission_category', function (Blueprint $table) {
            //
        });
        DB::table('permission_category')
            ->insert([
                [
                    'id' => 1,
                    'name' => 'Merchants'
                ],
                [
                    'id' => 2,
                    'name' => 'Banks Management'
                ],
                [
                    'id' => 3,
                    'name' => 'Reports'
                ],
                [
                    'id' => 4,
                    'name' => 'Terminal accounts'
                ],
                [
                    'id' => 5,
                    'name' => 'Transaction to do'
                ],
                [
                    'id' => 6,
                    'name' => 'Customers'
                ],
                [
                    'id' => 7,
                    'name' => 'Working days'
                ],
                [
                    'id' => 8,
                    'name' => 'Settings'
                ]

            ]);
            DB::table('permissions')
            ->insert([
                [
                    'id' => 1,
                    'name' => 'View',
                    'category_id' => 1
                ],
                [
                    'id' => 2,
                    'name' => 'Add',
                    'category_id' => 1
                ],
                [
                    'id' => 3,
                    'name' => 'Edit',
                    'category_id' => 1
                ],
                [
                    'id' => 4,
                    'name' => 'Show all edit fields',
                    'category_id' => 1
                ],
                [
                    'id' => 5,
                    'name' => 'Block/Unblock',
                    'category_id' => 1
                ],
                [
                    'id' => 6,
                    'name' => 'View',
                    'category_id' => 2
                ],
                [
                    'id' => 7,
                    'name' => 'Add',
                    'category_id' => 2
                ],
                [
                    'id' => 8,
                    'name' => 'Edit',
                    'category_id' => 2
                ],
                [
                    'id' => 9,
                    'name' => 'View',
                    'category_id' => 3
                ],
                [
                    'id' => 10,
                    'name' => 'Export Excel',
                    'category_id' => 3
                ],
                [
                    'id' => 11,
                    'name' => 'View',
                    'category_id' => 4
                ],
                [
                    'id' => 12,
                    'name' => 'Edit',
                    'category_id' => 4
                ],
                [
                    'id' => 13,
                    'name' => 'View',
                    'category_id' => 5
                ],
                [
                    'id' => 14,
                    'name' => 'Edit',
                    'category_id' => 5
                ],
                [
                    'id' => 15,
                    'name' => 'Albaraka external report',
                    'category_id' => 5
                ],
                [
                    'id' => 16,
                    'name' => 'Albaraka internal report',
                    'category_id' => 5
                ],
                [
                    'id' => 17,
                    'name' => 'Import excel',
                    'category_id' => 5
                ],
                [
                    'id' => 18,
                    'name' => 'Export excel',
                    'category_id' => 5
                ],
                [
                    'id' => 19,
                    'name' => 'View',
                    'category_id' => 6
                ],
                [
                    'id' => 20,
                    'name' => 'Export Excel',
                    'category_id' => 6
                ],
                [
                    'id' => 21,
                    'name' => 'View',
                    'category_id' => 7
                ],
                [
                    'id' => 22,
                    'name' => 'Add event',
                    'category_id' => 7
                ],
                [
                    'id' => 23,
                    'name' => 'View',
                    'category_id' => 8
                ],
                [
                    'id' => 24,
                    'name' => 'Edit',
                    'category_id' => 8
                ],
            ]);
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission_category', function (Blueprint $table) {
            //
        });
    }
};
