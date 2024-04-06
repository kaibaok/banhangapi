<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('cid')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });

        DB::table('customer')->insert([
            [
                'id' => 1,
                'full_name' => 'khach hang 1',
                'cid' => '123123',
                'address'=>'34/1 kp4 nha be',
                'phone'=> '093919129',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'full_name' => 'khach hang 2',
                'cid' => '123123',
                'address'=>'34/1 kp4 nha be',
                'phone'=> '093919129',
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
        Schema::dropIfExists('customer');

    }
}
