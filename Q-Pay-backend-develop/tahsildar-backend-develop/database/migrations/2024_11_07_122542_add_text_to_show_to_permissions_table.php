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
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('text_to_show')->after('name')->nullable();
        });
        
        DB::table('permissions')->update(['text_to_show' => DB::raw('name')]);
        DB::table('permissions')->where('id',17)->update(['text_to_show' => 'Update Status Excel']);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('show_to_permissions', function (Blueprint $table) {
            //
        });
    }
};
