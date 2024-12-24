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
        Schema::table('terminal_banks', function (Blueprint $table) {           
            $table->dropForeign(['system_bank_data_id']);
            $table->dropColumn(['system_bank_data_id']);
            $table->foreignId('bank_id')->nullable()->constrained('banks')->restrictOnDelete();
            $table->string('bank_account_number')->nullable();
        });
        DB::table('terminal_banks')->where('id',2)->delete();
        DB::table('terminal_banks')->where('id',1)->update(['bank_id' => 14]);
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
