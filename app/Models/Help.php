<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Help extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'help';

    public static function getHelpList()
    {
        $cache = Redis::get('help:list');
        $data  = json_decode($cache, true);
        if (empty($data)) {
            $data = self::saveHelpListCache();
        }

        return $data;
    }

    public static function saveHelpListCache()
    {
        $list = self::all();
        Redis::set('help:list', json_encode($list), 86400);

        return $list;
    }

}
