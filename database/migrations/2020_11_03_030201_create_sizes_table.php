<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items');
            $table->unsignedInteger('size');
            $table->unsignedInteger('width')->nullable(); // 身幅
            $table->unsignedInteger('sholder_width')->nullable(); // 肩幅
            $table->unsignedInteger('raglan_sleeve_length')->nullable(); // 裄丈
            $table->unsignedInteger('sleeve_length')->nullable(); // 袖丈
            $table->unsignedInteger('length')->nullable(); // 着丈
            $table->unsignedInteger('waist')->nullable(); // ウエスト
            $table->unsignedInteger('hip')->nullable(); // ヒップ
            $table->unsignedInteger('rise')->nullable(); // 股上
            $table->unsignedInteger('inseam')->nullable(); // 股下
            $table->unsignedInteger('thigh_width')->nullable(); // わたり(もも幅)
            $table->unsignedInteger('outseam')->nullable(); // パンツ総丈
            $table->unsignedInteger('sk_length')->nullable(); // スカート丈
            $table->unsignedInteger('hem_width')->nullable(); // 裾幅
            $table->unsignedInteger('weight')->nullable(); // 重量
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
        Schema::dropIfExists('sizes');
    }
}
