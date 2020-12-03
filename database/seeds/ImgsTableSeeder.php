<?php

use Illuminate\Database\Seeder;

class ImgsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('imgs')->truncate();

        $file = new SplFileObject('database/csv/imgs_demo.csv');

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
                    'file_name' => $line[1],
                    'img_category' => $line[2]
                ];
            }
            $row_count++;
        }

        DB::table('imgs')->insert($list);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
