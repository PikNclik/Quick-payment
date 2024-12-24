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
        Schema::create('transaction_to_dos', function (Blueprint $table) {
            $table->id();
            $table->double('amount');
            $table->boolean('executed')->default(false);
            $table->string('from_bank_account_number');
            $table->string('to_bank_account_number');
            $table->foreignId('from_bank_id')->constrained('banks')->restrictOnDelete();
            $table->foreignId('to_bank_id')->constrained('banks')->restrictOnDelete();
            $table->foreignId('payment_id')->constrained('payments')->restrictOnDelete();
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
        Schema::dropIfExists('transaction_to_dos');
    }
};
