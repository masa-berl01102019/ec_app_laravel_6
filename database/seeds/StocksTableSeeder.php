<?php

use Illuminate\Database\Seeder;

class StocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('stocks')->truncate();

        $file = new SplFileObject('database/csv/stocks_demo.csv');

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
                    'item_id' => $line[0],
                    'color' => $line[1],
                    'quantity_s' => $line[2],
                    'quantity_m' => $line[3],
                    'quantity_l' => $line[4]
                ];
            }
            $row_count++;
        }

        DB::table('stocks')->insert($list);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
