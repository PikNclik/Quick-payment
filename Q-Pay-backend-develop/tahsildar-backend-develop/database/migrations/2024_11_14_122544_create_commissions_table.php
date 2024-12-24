<?php

use App\Definitions\CommissionTypes;
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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('terminal_bank_id')->constrained('terminal_banks')->restrictOnDelete();
            $table->integer('commission_percentage');
            $table->integer('commission_fixed');
            $table->integer('min');
            $table->integer('max');
            $table->string('bank_account_number');
            $table->enum('type', CommissionTypes::TYPES);
            $table->timestamps();
            $table->unique('terminal_bank_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commissions');
    }
};
