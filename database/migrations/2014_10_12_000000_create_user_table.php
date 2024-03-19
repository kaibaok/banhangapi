<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->integer('permission'); // 1: user 2 admin
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('user')->insert([
            [
                'id' => 1,
                'username' => 'test_user',
                'email' => 'test_user@gmail.com',
                'password'=>'$2y$10$HazXNcTt7MvO3oJ/YglTve/iMHBCEaj52Uv/11WP45K1LEsvL.Y4O',
                'permission'=> 1
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
