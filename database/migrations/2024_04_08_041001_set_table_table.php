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
                'name' => 'B.1',
                'status' => config('constants.set_table_status.avaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'B.2',
                'status' => config('constants.set_table_status.unavaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'B.3',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'name' => 'B.4',
                'status' => config('constants.set_table_status.avaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'name' => 'B.5',
                'status' => config('constants.set_table_status.unavaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 6,
                'name' => 'B.6',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 7,
                'name' => 'B.7',
                'status' => config('constants.set_table_status.avaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 8,
                'name' => 'B.8',
                'status' => config('constants.set_table_status.unavaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 9,
                'name' => 'B.9',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 10,
                'name' => 'B.10',
                'status' => config('constants.set_table_status.avaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 11,
                'name' => 'B.11',
                'status' => config('constants.set_table_status.unavaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 12,
                'name' => 'B.12',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 13,
                'name' => 'B.13',
                'status' => config('constants.set_table_status.avaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 14,
                'name' => 'B.14',
                'status' => config('constants.set_table_status.unavaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 15,
                'name' => 'B.15',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 16,
                'name' => 'B.16',
                'status' => config('constants.set_table_status.avaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 17,
                'name' => 'B.17',
                'status' => config('constants.set_table_status.unavaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 18,
                'name' => 'B.18',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 19,
                'name' => 'B.19',
                'status' => config('constants.set_table_status.avaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 20,
                'name' => 'B.20',
                'status' => config('constants.set_table_status.unavaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 21,
                'name' => 'B.21',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 22,
                'name' => 'B.22',
                'status' => config('constants.set_table_status.avaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 23,
                'name' => 'B.23',
                'status' => config('constants.set_table_status.unavaliable'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 24,
                'name' => 'B.24',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 25,
                'name' => 'B.25',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 26,
                'name' => 'B.26',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 27,
                'name' => 'B.27',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 28,
                'name' => 'B.28',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 29,
                'name' => 'B.29',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 30,
                'name' => 'B.30',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 31,
                'name' => 'B.31',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 32,
                'name' => 'B.32',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 33,
                'name' => 'B.33',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 34,
                'name' => 'B.34',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 35,
                'name' => 'B.35',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 36,
                'name' => 'B.36',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 37,
                'name' => 'B.37',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 38,
                'name' => 'B.38',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 39,
                'name' => 'B.39',
                'status' => config('constants.set_table_status.booking'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 40,
                'name' => 'B.40',
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
