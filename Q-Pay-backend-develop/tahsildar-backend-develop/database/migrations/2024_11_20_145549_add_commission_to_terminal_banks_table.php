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
        Schema::table('terminal_banks', function (Blueprint $table) {
            $table->foreignId('internal_commission_id')->nullable()->constrained('commissions')->restrictOnDelete();
            $table->foreignId('external_commission_id')->nullable()->constrained('commissions')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('terminal_banks', function (Blueprint $table) {
            //
        });
    }
};
