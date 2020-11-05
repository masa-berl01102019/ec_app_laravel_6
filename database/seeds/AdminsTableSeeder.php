<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // 一時的に外部キー制約を無効化

        DB::table('admins')->truncate(); // テーブルごと削除して再構築

        // php artisan make:seeder seeder名 コマンドでこのseederファイルを作成　テストデータの作成
        DB::table('admins')->insert([
            'name'              => 'admin',
            'email'             => 'admin@example.com',
            'password'          => Hash::make('12345678'), // DBに入れる時はHash::makeで作った値を入れてログイン時にはフォームで受け取ったパスワードをHash::checkで比較
            'remember_token'    => Str::random(10), // Str::random() は指定された長さのランダムな文字列を生成する
        ]);
        //  基本的なDBファサードの使い方
        //  use Illuminate\Support\Facades\DB; DB ファサードを use する
        //  DB::table('テーブル名')->queryビルダ;　の形でテーブル名を指定してテーブルに対してinsertやselectなどの操作を行える
        //  insert() は複数の配列を引数にとることが出来て、'カラム名' => '値'の形で格納することで一度のSQL文で複数のレコードを挿入できる。

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // 外部キー制約を有効化

    }
}
