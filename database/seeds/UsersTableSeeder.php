<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon; // 追加

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // 一時的に外部キー制約を無効化

        DB::table('users')->truncate(); // テーブルごと削除して再構築

        $file = new SplFileObject('database/csv/users_demo.csv');
        // SplFileObject(phpのファイル操作のためのクラス) でインスタンス作成
        $file->setFlags(
            \SplFileObject::READ_CSV | // CSV 列として行を読み込む
            \SplFileObject::READ_AHEAD | // 先読み/巻き戻しで読み出す
            \SplFileObject::SKIP_EMPTY | // 空行は読み飛ばす
            \SplFileObject::DROP_NEW_LINE // 行末の改行を読み飛ばす
        );
        // flagの設定

        $list = []; // 配列の初期化
        $row_count = 1;

        foreach($file as $line) {
            if($row_count > 1) { // 最初の一行目(headerの列)を読み込まないよう条件分岐
                $list[] = [
                    'name' => $line[0],
                    'gender' => $line[1],
                    'date_of_birth' => $line[2],
                    'tel' => $line[3],
                    'address' => $line[4],
                    'email' => $line[5],
                    'password' => Hash::make($line[6]),
                    'remember_token' => Str::random(10)
                ];
                // 取得した値をカラム名ごとに代入
            }
            $row_count++;
        }

        DB::table('users')->insert($list); // データの挿入

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // 外部キー制約を有効化

    }
}
