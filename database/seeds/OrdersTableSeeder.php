<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('orders')->truncate();

        $file = new SplFileObject('database/csv/orders_demo.csv');

        $file->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );

        $list = [];

        $row_count = 1;

        foreach($file as $line) {
            if($row_count > 1) {
                $list[] = [
                    'user_id' => $line[0],
                    'sub_total' => $line[1],
                    'tax_amount' => $line[2],
                    'total_amount' => $line[3],
                    'created_at' => $line[4]
                ];
            }
            $row_count++;
        }

        DB::table('orders')->insert($list);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
