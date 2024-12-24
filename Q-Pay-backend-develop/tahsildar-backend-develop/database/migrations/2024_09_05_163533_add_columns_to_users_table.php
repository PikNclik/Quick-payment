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
        Schema::table('users', function (Blueprint $table) {
            $table->string('business_name')->nullable()->default(null);
            $table->unsignedBigInteger('origin_id')->nullable()->default(null);
            $table->foreign('origin_id')->references('id')->on('origins');
            $table->unsignedBigInteger('business_type_id')->nullable()->default(null);
            $table->foreign('business_type_id')->references('id')->on('business_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
