<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'collection';

    /**
     * 用户收藏知识点
     * @param int $userId
     * @param int $knowledgeId
     * @return bool
     */
    public static function addMemberCollectionRecode($userId = 0, $knowledgeId = 0)
    {
        if (empty($userId) || empty($knowledgeId))  return false;

        $check = self::where('user_id', '=', $userId)->where('knowledge_id', '=', $knowledgeId)->first();
        if ($check) {
            return true;
        }

        $info = new self();
        $info->user_id = $userId;
        $info->knowledge_id = $knowledgeId;

        return $info->save();
    }

    /**
     * 用户收藏列表
     * @param $userId
     * @return mixed
     */
    public static function getMemberCollectionList($userId)
    {
        return self::where('user_id', '=', $userId)->get();
    }
}
