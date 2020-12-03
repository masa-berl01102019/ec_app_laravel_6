<?php

use Illuminate\Database\Seeder;

class DescriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('descriptions')->truncate();

        $file = new SplFileObject('database/csv/descriptions_demo.csv');

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
                    'title' => $line[1],
                    'body' => $line[2]
                ];
            }
            $row_count++;
        }

        DB::table('descriptions')->insert($list);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
