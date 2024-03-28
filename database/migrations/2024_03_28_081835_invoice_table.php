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
            $table->integer('status');
            $table->integer('delivery');
            $table->timestamps();
        });

        DB::table('invoice')->insert([
            [
                'id' => 1,
                'vat' => 10,
                'note'=> 'ko mún ăn trứng chiên, ít ngọt',                
                'delivery'=> config('constants.order_delivery.non_delivery'),
                'status' => config('constants.order_status.unpaid'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'vat' => 10,
                'note'=> 'ko mún ăn trứng chiên, ít ngọt 222',                
                'delivery'=> config('constants.order_delivery.delivery'),
                'status' => config('constants.order_status.paid'),
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
