<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class SetTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('set_table', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('status')->default(config('constants.set_table_status.avaliable'));
            $table->timestamps();
        });

        DB::table('set_table')->insert([
            [
                'id' => 1,
                'name' => 'bàn số 1',
                'status' => config('constants.set_table_status.avaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'bàn số 2',
                'status' => config('constants.set_table_status.unavaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'bàn số 3',
                'status' => config('constants.set_table_status.booking'),
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
        Schema::dropIfExists('set_table');
    }
}
