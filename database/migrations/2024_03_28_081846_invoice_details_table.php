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
            $table->integer('discount')->default(0);
            $table->integer('food_id');
            $table->integer('quantity')->default(0);
            $table->integer('price')->default(0);
            $table->integer('status')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        DB::table('invoice_details')->insert([
            [
                'id' => 1,
                'invoice_id' => 1,
                'discount' => 0,
                'food_id' => 1,
                'quantity' => 3,
                'price' => 90000,
                'status' => config('constants.order_detail_status.wait'),
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
                'price' => 90000,
                'status' => config('constants.order_detail_status.complete'),
                'note'=> 'nuocws mam ít mặn lại',                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'invoice_id' => 3,
                'discount' => 10000,
                'food_id' => 1,
                'quantity' => 3,
                'price' => 90000,
                'status' => config('constants.order_detail_status.process'),
                'note'=> 'ko mún ăn trứng chiên, ít ngọt',                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'invoice_id' => 3,
                'discount' => 0,
                'food_id' => 2,
                'quantity' => 1,
                'price' => 100,
                'status' => config('constants.order_detail_status.complete'),
                'note'=> 'nuocws mam ít mặn lại',                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'invoice_id' => 2,
                'discount' => 10000,
                'food_id' => 1,
                'quantity' => 3,
                'price' => 10000000,
                'status' => config('constants.order_detail_status.wait'),
                'note'=> 'ko mún ăn trứng chiên, ít ngọt',                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 6,
                'invoice_id' => 2,
                'discount' => 0,
                'food_id' => 2,
                'quantity' => 1,
                'price' => 100,
                'status' => config('constants.order_detail_status.complete'),
                'note'=> 'nuocws mam ít mặn lại',                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 7,
                'invoice_id' => 4,
                'discount' => 10000,
                'food_id' => 1,
                'quantity' => 3,
                'price' => 10000000,
                'status' => config('constants.order_detail_status.wait'),
                'note'=> 'ko mún ăn trứng chiên, ít ngọt',                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 8,
                'invoice_id' => 4,
                'discount' => 0,
                'food_id' => 2,
                'quantity' => 1,
                'price' => 100,
                'status' => config('constants.order_detail_status.complete'),
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
