<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class FoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('code');
            $table->integer('price');
            $table->text('image_url');
            $table->text('description');
            $table->string('name');
            $table->integer('status');
            $table->timestamps();
        });

        DB::table('food')->insert([
            [
                'id' => 1,
                'category_id' => 1,
                'code' => '112345',
                'price' => 1000,
                'image_url'=> '',
                'description'=> 'description ###$$$',
                'name'=> 'com chien dien chau',
                'status' => config('constants.status.visible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
             [
                'id' => 2,
                'category_id' => 2,
                'code' => '1231',
                'price' => 1000222,
                'image_url'=> '',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'nuoc mam',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food');
    }
}
