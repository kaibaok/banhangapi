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
            $table->string('code')->nullable();
            $table->integer('price')->default(0);
            $table->text('image_url')->nullable();
            $table->text('description')->nullable();
            $table->string('name');
            $table->integer('status')->default(config('constants.status.invisible'));
            $table->timestamps();
        });

        DB::table('food')->insert([
            // cate: 1 - món mặn
            [
                'id' => 1,
                'category_id' => 1,
                'code' => 'comchienduongchau',
                'price' => 1000,
                'image_url'=> 'https://i.ibb.co/q5NYcwX/comchienduongchau.png',
                'description'=> 'description ###$$$',
                'name'=> 'Cơm chiên dương châu',
                'status' => config('constants.status.visible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'category_id' => 1,
                'code' => 'comchienhaisan',
                'price' => 1000222,
                'image_url'=> 'https://i.ibb.co/Q6vC1T1/comchienhaisan.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Cơm chiên hải sản',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'category_id' => 1,
                'code' => 'comchiencaman',
                'price' => 1000222,
                'image_url'=> 'https://i.ibb.co/fd1Kj8D/comchiencaman.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Cơm chiên cá mặn',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'category_id' => 1,
                'code' => 'tomsotthai',
                'price' => 1000222,
                'image_url'=> 'https://i.ibb.co/jvShV7g/tomsotthai.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Tôm sốt thái',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'category_id' => 1,
                'code' => 'sungamamtoi',
                'price' => 1000222,
                'image_url'=> 'https://i.ibb.co/rFgbS7V/sungamamtoi.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Sụn gà mắm tỏi',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 6,
                'category_id' => 1,
                'code' => 'cataituonghaphanh',
                'price' => 1000222,
                'image_url'=> 'https://i.ibb.co/G9X6jd7/cataituonghaphanh.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Cá tai tượng hấp hành',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 7,
                'category_id' => 1,
                'code' => 'catamhapsa',
                'price' => 1000222,
                'image_url'=> 'https://i.ibb.co/RPPq9M2/catamhapsa.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Cá tầm hấp sả',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 8,
                'category_id' => 1,
                'code' => 'cuahoangdehap',
                'price' => 1000222,
                'image_url'=> 'https://i.ibb.co/55p5pYt/cuahoangdehap.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Cua hoàng đế hấp',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 9,
                'category_id' => 1,
                'code' => 'baongunuongphomai',
                'price' => 1000222,
                'image_url'=> 'https://i.ibb.co/gTV8thJ/baongunuongphomai.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Bào ngư nướng phô mai',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 10,
                'category_id' => 1,
                'code' => 'tomhumalaskahap',
                'price' => 1000222,
                'image_url'=> 'https://i.ibb.co/hZfCt84/tomhumalaskahap.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Tôm Hùm Alaska Hấp',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 11,
                'category_id' => 1,
                'code' => 'tomhumalaskanuongphomai',
                'price' => 1000222,
                'image_url'=> 'https://i.ibb.co/RjfvLx0/tomhumalaskanuongphomai.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Tôm hùm Alaska nướmg phô mai',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 12,
                'category_id' => 1,
                'code' => 'ngheuhapthai',
                'price' => 1000222,
                'image_url'=> 'https://i.ibb.co/SdxfFQR/ngheuhapthai.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Nghêu hấp thái',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 13,
                'category_id' => 1,
                'code' => 'ochuongsotphomai',
                'price' => 1000222,
                'image_url'=> 'https://i.ibb.co/p4Fvx8d/ochuongsotphomai.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Ốc hương sốt phô mai',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // cate 2- nước giải khát
            [
                'id' => 14,
                'category_id' => 2,
                'code' => 'nuocngotpepsi',
                'price' => 150000,
                'image_url'=> 'https://i.ibb.co/ZNRSgw5/nuocngotpepsi.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Nước ngọt Pepsi',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 15,
                'category_id' => 2,
                'code' => 'nuocngotcoca',
                'price' => 150000,
                'image_url'=> 'https://i.ibb.co/m6HZ1J5/nuocngotcoca.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Nước ngọt Coca',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 16,
                'category_id' => 2,
                'code' => 'nuocngot7up',
                'price' => 150000,
                'image_url'=> 'https://i.ibb.co/fkZRBw6/nuocngot7up.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Nước ngọt 7up',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 17,
                'category_id' => 2,
                'code' => 'nuocngotfanta',
                'price' => 15000,
                'image_url'=> 'https://i.ibb.co/VYXr1Cx/nuocngotfanta.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Nước ngọt Fanta',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 18,
                'category_id' => 2,
                'code' => 'nuocngotsting',
                'price' => 15000,
                'image_url'=> 'https://i.ibb.co/6mzM9B6/nuocngotsting.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Nước ngọt Sting',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 19,
                'category_id' => 2,
                'code' => 'nuocsuoi',
                'price' => 10000,
                'image_url'=> 'https://i.ibb.co/WfRKWv6/nuocsuoi.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Nước suối',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 20,
                'category_id' => 2,
                'code' => 'nuoctrada',
                'price' => 3000,
                'image_url'=> 'https://i.ibb.co/WP8BWYJ/nuoctrada.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Nước trà đá',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 21,
                'category_id' => 2,
                'code' => 'biatiger',
                'price' => 25000,
                'image_url'=> 'https://i.ibb.co/HhKYrBP/biatiger.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Bia Tiger',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 22,
                'category_id' => 2,
                'code' => 'biaheineken',
                'price' => 25000,
                'image_url'=> 'https://i.ibb.co/18JctPN/biaheineken.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Bia Heineken',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //cate 3 - Tráng miệng
            [
                'id' => 23,
                'category_id' => 3,
                'code' => 'banhflan',
                'price' => 25000,
                'image_url'=> 'https://i.ibb.co/M86B0xG/banhflan.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Bánh Flan',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 24,
                'category_id' => 3,
                'code' => 'panacota',
                'price' => 25000,
                'image_url'=> 'https://i.ibb.co/rmJc2kF/panacota.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Panacota',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 25,
                'category_id' => 3,
                'code' => 'traicay',
                'price' => 25000,
                'image_url'=> 'https://i.ibb.co/Qp454NF/traicay.png',
                'description'=> 'description 2222 ###$$$',
                'name'=> 'Trái Cây',
                'status' => config('constants.status.invisible'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
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
