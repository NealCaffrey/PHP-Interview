<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Browse extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'browse';

    /**
     * 记录用户浏览知识点
     * @param int $userId
     * @param int $knowledgeId
     * @return bool
     */
    public static function addMemberBrowseRecord($userId = 0, $knowledgeId = 0)
    {
        if (empty($userId) || empty($knowledgeId)) return false;

        $info = new self();
        $info->user_id = $userId;
        $info->knowledge_id = $knowledgeId;

        return $info->save();
    }

    /**
     * 用户浏览记录
     * @param int $userId
     * @return mixed
     */
    public static function getMemberBrowseList($userId = 0)
    {
        return self::where('user_id', '=', $userId)->get();
    }
}
