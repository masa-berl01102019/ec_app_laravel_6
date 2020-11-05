<?php

use Illuminate\Database\Seeder;

class CategoryItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('category_item')->truncate();

        $file = new SplFileObject('database/csv/category_item_demo.csv');

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
                    'id' => $line[0],
                    'item_id' => $line[1],
                    'category_id' => $line[2]
                ];
            }
            $row_count++;
        }

        DB::table('category_item')->insert($list);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
