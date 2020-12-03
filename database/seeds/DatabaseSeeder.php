<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // seederを実行できるように下記を記述 ＊作成したseederクラス名::classをcallの引数に渡しておく
         $this->call([
             UsersTableSeeder::class,
             AdminsTableSeeder::class,
             ItemsTableSeeder::class,
             CategoriesTableSeeder::class,
             CategoryItemTableSeeder::class,
             SizesTableSeeder::class,
             StocksTableSeeder::class,
             OrdersTableSeeder::class,
             OrderDetailsTableSeeder::class,
             DescriptionsTableSeeder::class,
             ImgsTableSeeder::class,
         ]);
    }
}
