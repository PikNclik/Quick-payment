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
        Schema::create('system_bank_data', function (Blueprint $table) {
            $table->id();
            $table->string('bank_account_number')->nullable();
            $table->boolean('default_transaction')->default(false);
            $table->foreignId('bank_id')->constrained('banks')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_bank_data');
    }
};
