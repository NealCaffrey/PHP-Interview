<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'category';

    public function knowledge()
    {
        return $this->hasMany(Knowledge::class, 'category_id', 'id');
    }

    /**
     * 获取分类列表缓存
     * @return Category[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public static function getCategoryListByCache()
    {
        $cache = Redis::get('category:list');
        $data  = json_decode($cache, true);
        if (empty($data)) {
            $data = self::saveCategoryListToCache();
        }

        return $data;
    }

    /**
     * 保存分类缓存
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function saveCategoryListToCache()
    {
        $list = self::withcount('knowledge')->orderByDesc('sort')->get()->toArray();
        foreach ($list as $k => $v) {
            $list[$k]['images'] = Storage::disk('qiniu')->getDriver()->downloadUrl($v['images']);
        }
        Redis::set('category:list', json_encode($list), 86400);

        return $list;
    }
}
