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
     * @param $userId
     * @param $knowledgeId
     * @return bool
     */
    public function memberBrowseKnowledge($userId, $knowledgeId)
    {
        return $this->save([
            'user_id' => $userId,
            'knowledge_id' => $knowledgeId
        ]);
    }

    /**
     * 用户浏览记录
     * @param $userId
     * @return mixed
     */
    public static function getMemberBrowseList($userId)
    {
        return self::where('user_id', '=', $userId)->get();
    }
}
