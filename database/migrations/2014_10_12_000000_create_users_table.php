<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_last_name',25)->nullable();
            $table->string('user_first_name',25)->nullable();
            $table->string('user_last_name_kana',25)->nullable();
            $table->string('user_first_name_kana',25)->nullable();
            $table->unsignedTinyInteger('gender')->nullable(); // 0~255 0:man 1:woman 2:others 3:no answer
            $table->date('birthday')->nullable();
            $table->string('tel', 20)->nullable();
            $table->string('post_code', 20)->nullable();
            $table->string('prefecture',50)->nullable();
            $table->string('municipality',50)->nullable();
            $table->string('street_name',50)->nullable();
            $table->string('street_number',50)->nullable();
            $table->string('building',50)->nullable();
            $table->string('email',50)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('delete_flg')->default(0);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
