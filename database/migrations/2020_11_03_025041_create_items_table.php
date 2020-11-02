<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_name', 100); // VARCHAR型　※デフォルト255文字
            $table->unsignedInteger('price'); // 符号なしINTカラム
            $table->unsignedInteger('cost'); // 符号なしINTカラム
            $table->string('comment', 100); // 100文字指定
            $table->text('description');
            $table->set('season', ['spring', 'summer', 'autumn', 'winter']);
            $table->string('main_pic');
            $table->string('thumbnail_pic1')->nullable(); // nullを許容
            $table->string('thumbnail_pic2')->nullable();
            $table->string('thumbnail_pic3')->nullable();
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
        Schema::dropIfExists('items');
    }
}
