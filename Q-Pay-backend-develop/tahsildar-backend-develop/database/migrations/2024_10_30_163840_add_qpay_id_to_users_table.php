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
            $table->string('qpay_id')->after('id')->nullable()->unique();
        });

        $users = \App\Models\User::all();
        foreach ($users as $user){
          //  while (true){
                try {
                   $qpayId="Q". chr(rand(97, 122)) . chr(rand(97, 122)) . rand(0,9) . rand(0,9) . rand(0,9);
                    $user->update(["qpay_id"=>$qpayId]);
               //     break;
                } catch (Exception $e){}
           // }


        }
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
