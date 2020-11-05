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
                    'comment' => $line[3],
                    'description' => $line[4],
                    'season' => $line[5],
                    'main_pic' => $line[6],
                    'thumbnail_pic1' => $line[7],
                    'thumbnail_pic2' => $line[8],
                    'thumbnail_pic3' => $line[9]
                ];
            }
            $row_count++;
        }

        DB::table('items')->insert($list);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
