<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// 追加

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
                    'user_last_name' => $line[0],
                    'user_first_name' => $line[1],
                    'user_last_name_kana' => $line[2],
                    'user_first_name_kana' => $line[3],
                    'gender' => $line[4],
                    'birthday' => $line[5],
                    'tel' => $line[6],
                    'post_code' => $line[7],
                    'prefecture' => $line[8],
                    'municipality' => $line[9],
                    'street_name' => $line[10],
                    'street_number' => $line[11],
                    'building' => $line[12],
                    'email' => $line[13],
                    'password' => Hash::make($line[14]),
                    'remember_token' => Str::random(11)
                ];
                // 取得した値をカラム名ごとに代入
            }
            $row_count++;
        }

        DB::table('users')->insert($list); // データの挿入

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // 外部キー制約を有効化

    }
}
