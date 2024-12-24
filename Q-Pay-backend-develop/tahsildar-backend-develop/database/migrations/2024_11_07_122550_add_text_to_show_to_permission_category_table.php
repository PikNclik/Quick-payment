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
        Schema::table('permission_category', function (Blueprint $table) {
            $table->string('text_to_show')->after('name')->nullable();
        });

        DB::table('permission_category')->update(['text_to_show' => DB::raw('name')]);
        DB::table('permission_category')->where('name','Merchants')->update(['text_to_show' => 'Q-PAY Users']);
        DB::table('permission_category')->where('name','Transaction to do')->update(['text_to_show' => 'Settlement Files']);
        DB::table('permission_category')->where('name','Working days')->update(['text_to_show' => 'Update working days']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('show_to_permission_category', function (Blueprint $table) {
            //
        });
    }
};
