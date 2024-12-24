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
        Schema::create('origins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        DB::table('origins')
        ->insert([[
            'id' => 1,
            'name' => 'ALamin'
        ]]);
        DB::table('origins')
        ->insert([[
            'id' => 2,
            'name' => 'Java Source'
        ]]);
        DB::table('origins')
        ->insert([[
            'id' => 3,
            'name' => 'Automata4'
        ]]);
        DB::table('origins')
        ->insert([[
            'id' => 4,
            'name' => 'Normal user'
        ]]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('origins');
    }
};
