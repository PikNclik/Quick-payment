<?php

use App\Definitions\PaymentTypeEnums;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable()->unique();
            $table->double('amount');
            $table->string('details')->nullable();
            $table->tinyInteger('status');
            $table->enum('type', PaymentTypeEnums::TYPES);
            $table->dateTime('expiry_date')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('scheduled_date')->nullable();
            $table->double('fees_percentage');
            $table->double('fees_value');
            $table->string('token')->nullable();
            $table->string('ref_num')->nullable();
            $table->string('rrn')->nullable();
            $table->string('hash_card')->nullable();
            $table->foreignId('customer_id')->constrained('customers')->restrictOnDelete();
            $table->foreignId('terminal_bank_id')->constrained('terminal_banks')->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
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
        Schema::create('payments', function (Blueprint $table) {
            //
        });
    }
};
