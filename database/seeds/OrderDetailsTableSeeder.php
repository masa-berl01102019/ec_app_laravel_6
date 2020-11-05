<?php

use Illuminate\Database\Seeder;

class OrderDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('order_details')->truncate();

        $file = new SplFileObject('database/csv/order_details_demo.csv');

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
                    'order_id' => $line[0],
                    'item_id' => $line[1],
                    'item_name' => $line[2],
                    'price' => $line[3],
                    'color' => $line[4],
                    'size' => $line[5],
                    'quantity' => $line[6]
                ];
            }
            $row_count++;
        }

        DB::table('order_details')->insert($list);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
