<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //先清除数据
        DB::table('category')->truncate();

        $data = ['PHP基础', 'PHP高级', 'Mysql', 'Linux', 'Nginx', 'Redis', 'MongoDB', 'Kafka', 'Docker', 'Vue'];
        $list = [];
        foreach ($data as $k => $v) {
            $list[] = [
                'category_name' => $v
            ];
        }

        DB::table('category')->insert($list);
    }
}
