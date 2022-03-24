<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Version extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'version';

    public static function getVersionList()
    {
        $cache = Redis::get('version:list');
        $data  = json_decode($cache, true);
        if (empty($data)) {
            $data = self::saveVersionListCache();
        }

        return $data;
    }

    public static function saveVersionListCache()
    {
        $list = self::all();
        Redis::set('version:list', json_encode($list), 86400);

        return $list;
    }
}
