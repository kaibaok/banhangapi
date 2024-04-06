<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('permission')->default(1); // 1: user staff default 2: admin staff
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('user')->insert([
            [
                'id' => 1,
                'username' => 'Name_Admin',
                'email' => 'admin@gmail.com',
                'password'=>'$2y$10$HazXNcTt7MvO3oJ/YglTve/iMHBCEaj52Uv/11WP45K1LEsvL.Y4O', // 123456
                'permission'=> config('constants.permission.admin'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'username' => 'Name_Staff',
                'email' => 'staff@gmail.com',
                'password'=>'$2y$10$HazXNcTt7MvO3oJ/YglTve/iMHBCEaj52Uv/11WP45K1LEsvL.Y4O', // 123456
                'permission'=> config('constants.permission.staff'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'username' => 'Name_Chef',
                'email' => 'chef@gmail.com',
                'password'=>'$2y$10$HazXNcTt7MvO3oJ/YglTve/iMHBCEaj52Uv/11WP45K1LEsvL.Y4O', // 123456
                'permission'=> config('constants.permission.chef'),
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
        Schema::dropIfExists('user');
    }
}
