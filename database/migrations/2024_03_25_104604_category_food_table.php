<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoryFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_food', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('status');
            $table->timestamps();
        });

        DB::table('food')->insert([
            [
                'id' => 1,
                'name'=> 'đồ ăn mặn',
                'status' => 1,
            ],
            [
                'id' => 2,
                'name'=> 'đồ uống',
                'status' => 1,
            ],
            [
                'id' => 3,
                'name'=> 'trái cây, tráng miệng',
                'status' => 1,
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
        Schema::dropIfExists('category_food');
    }
}
