<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class InvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->integer('vat');
            $table->text('note');
            $table->integer('status')->default(0);
            $table->integer('confirm')->default(0);
            $table->integer('delivery')->default(0);
            $table->integer('desk_id')->default(0);
            $table->integer('user_id');  // staff
            $table->integer('customer_id'); // customer
            $table->integer('discount')->default(0); // % discount
            $table->timestamps();
        });

        DB::table('invoice')->insert([
            [
                'id' => 1,
                'vat' => 10,
                'note'=> 'ko mún ăn trứng chiên, ít ngọt',                
                'delivery'=> config('constants.order_delivery.non_delivery'),
                'status' => config('constants.order_status.unpaid'),
                'confirm' => config('constants.order_confirm.complete'),
                'desk_id' => 1,
                'user_id' => 1,
                'customer_id' => 1,
                'discount' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'vat' => 10,
                'note'=> 'ko mún ăn trứng chiên, ít ngọt 222',                
                'delivery'=> config('constants.order_delivery.delivery'),
                'status' => config('constants.order_status.paid'),
                'confirm' => config('constants.order_confirm.wait'),
                'desk_id' => 2,
                'user_id' => 2,
                'customer_id' => 2,
                'discount' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'vat' => 10,
                'note'=> 'nhieu mon vo',                
                'delivery'=> config('constants.order_delivery.non_delivery'),
                'status' => config('constants.order_status.paid'),
                'confirm' => config('constants.order_confirm.process'),
                'desk_id' => 3,
                'user_id' => 3,
                'customer_id' => 2,
                'discount' => 10,
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
        Schema::dropIfExists('invoice');
        
    }
}
