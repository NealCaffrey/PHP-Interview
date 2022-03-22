<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'question';

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * 生成试卷
     * @param array $categoryIds
     * @param int $number
     * @param int $pattern 1随机 2顺序
     * @return mixed
     */
    public static function generateExam($categoryIds = [], $number = 10, $pattern = 1)
    {
        if ($pattern == 1) {
            //随机
            $data = self::whereIn('category_id', $categoryIds)->orderByDesc('sort')->get()->toArray();
            if ($data) {
                shuffle($data);
                $data = array_slice($data, 0, $number);
            }
        } else {
            //顺序
            $data = self::whereIn('category_id', $categoryIds)->orderByDesc('sort')->limit($number)->get()->toArray();
        }

        //处理数据
        foreach ($data as $k => $v) {
            $data[$k]->select_content = json_decode($v->select_content, true);
        }

        return $data;
    }
}
