<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Knowledge extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;
    use HasFactory;

    protected $table = 'knowledge';

    /**
     * 关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * 获取知识点总数
     * @return mixed
     */
    public static function getKnowledgeTotalNum()
    {
        $num = Redis::get('know:total');
        if (empty($num)) {
            $num = self::saveKnowledgeTotalNum();
        }

        return $num;
    }

    /**
     * 保存知识点总数
     * @return mixed
     */
    public static function saveKnowledgeTotalNum()
    {
        $num = self::count();
        Redis::set('know:total', $num, 86400);

        return $num;
    }

    /**
     * 获取分类下知识点列表
     * @param int $categoryId
     * @return mixed|void
     */
    public static function getKnowledgeListCacheByCategory($categoryName = '')
    {
        $cache = Redis::get('know:list:' . $categoryName);
        $data  = json_decode($cache);
        if (empty($data)) {
            $data = self::saveKnowledgeListCacheByCategory($categoryName);
        }

        return $data;
    }

    /**
     * 保存分类下知识点列表
     * @param string $categoryName
     * @return mixed
     */
    public static function saveKnowledgeListCacheByCategory($categoryName = '')
    {
        $keyName = 'know:list:' . $categoryName;
        $category = Category::where('alias', '=', $categoryName)->first();
        if (empty($category)) {
            Redis::set($keyName, json_encode([]), 300);//如果没有此分类，缓存空结果
        }

        $data = self::where('category_id', '=', $category->id)->get();
        Redis::set($keyName, json_encode($data), 86400);

        return $data;
    }

    /**
     * 获取知识点详情缓存
     * @param $id
     * @return mixed
     */
    public static function getKnowledgeInfo($id)
    {
        $cache = Redis::get('know:info:' . $id);
        $data  = json_decode($cache);
        if (empty($data)) {
            $data = self::saveKnowledgeInfo($id);
        }

        return $data;
    }

    /**
     * 保存知识点详情缓存
     * @param $id
     * @return mixed
     */
    public static function saveKnowledgeInfo($id)
    {
        $data = self::with(['category' => function($query) {
            $query->select('id', 'category_name');
        }])->find($id);
        if (empty($data)) {
            return [];
        }

        //上一篇
        $prev = self::where('id', '<', $id)->where('category_id', '=', $data->category_id)->max('id');
        $data['prev'] = $prev ?: 0;

        //下一篇
        $next = self::where('id', '>', $id)->where('category_id', '=', $data->category_id)->min('id');
        $data['next'] = $next ?: 0;

        Redis::set('know:info:' . $id, json_encode($data));

        return $data;
    }

    /**
     * 收藏列表
     * @return mixed
     */
    public static function getCollectionList()
    {
        $cache = Redis::get('know:collection');
        $data  = json_decode($cache);
        if (empty($data)) {
            $data = self::saveCollectionList();
        }

        return $data;
    }

    /**
     * 保存收藏列表
     * @return mixed
     */
    public static function saveCollectionList()
    {
        $data = Knowledge::orderByDesc('collection_num')->limit(100)->get(['id', 'question']);
        Redis::set('know:collection', json_encode($data), 86400);

        return $data;
    }
}
