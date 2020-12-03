<?php

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('items')->truncate();

        $file = new SplFileObject('database/csv/items_demo.csv');

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
                    'item_name' => $line[0],
                    'price' => $line[1],
                    'cost' => $line[2],
                    'season' => $line[3],
                    'made_in' => $line[4]
                ];
            }
            $row_count++;
        }

        DB::table('items')->insert($list);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
