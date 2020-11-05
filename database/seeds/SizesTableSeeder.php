<?php

use Illuminate\Database\Seeder;

class SizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('sizes')->truncate();

        $file = new SplFileObject('database/csv/sizes_demo.csv');

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
                    'size' => $line[1],
                    'width' => $line[2],
                    'sholder_width' => $line[3],
                    'raglan_sleeve_length' => $line[4],
                    'sleeve_length' => $line[5],
                    'length' => $line[6],
                    'waist' => $line[7],
                    'hip' => $line[8],
                    'rise' => $line[9],
                    'inseam' => $line[10],
                    'thigh_width' => $line[11],
                    'outseam' => $line[12],
                    'sk_length' => $line[13],
                    'hem_width' => $line[14],
                    'weight' => $line[15]
                ];
            }
            $row_count++;
        }

        DB::table('sizes')->insert($list);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
