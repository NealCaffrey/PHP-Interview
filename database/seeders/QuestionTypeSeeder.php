<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //先清除数据
        DB::table('question_type')->truncate();

        $data = [
            1 => '单选题',
            2 => '多选题',
            3 => '判断题',
            4 => '问答题'
        ];
        $list = [];
        foreach ($data as $k => $v) {
            $list[] = [
                'name' => $v
            ];
        }

        DB::table('question_type')->insert($list);
    }
}
