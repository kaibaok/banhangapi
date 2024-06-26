<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class UserInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_info', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('full_name');
            $table->string('cid');
            $table->string('address');
            $table->string('phone');
            $table->timestamps();
        });

        DB::table('user_info')->insert([
            [
                'user_id' => 1,
                'full_name' => 'nguyen van a',
                'cid' => '123123',
                'address'=>'34/1 kp4 nha be',
                'phone'=> '093919129',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'full_name' => 'tran thi b',
                'cid' => '123123',
                'address' => '33/1 kp5 nha be',
                'phone' => '093919112',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'full_name' => 'vo thanh c',
                'cid' => '123123',
                'address' => '22/1 kp6 nha be',
                'phone' => '039191292',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_info');
    }
}
