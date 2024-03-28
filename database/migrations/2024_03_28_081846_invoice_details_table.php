<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class InvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->integer('discount');
            $table->integer('food_id');
            $table->integer('quantity');
            $table->integer('price');
            $table->text('note');
            $table->timestamps();
        });

        DB::table('invoice_details')->insert([
            [
                'id' => 1,
                'invoice_id' => 1,
                'discount' => 10000,
                'food_id' => 1,
                'quantity' => 3,
                'price' => 10000000,
                'note'=> 'ko mún ăn trứng chiên, ít ngọt',                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'invoice_id' => 1,
                'discount' => 0,
                'food_id' => 2,
                'quantity' => 1,
                'price' => 100,
                'note'=> 'nuocws mam ít mặn lại',                
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
        Schema::dropIfExists('invoice_details');

    }
}
