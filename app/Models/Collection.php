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
     * @param $userId
     * @param $knowledgeId
     * @return bool
     */
    public function memberCollectionKnowledge($userId, $knowledgeId)
    {
        return $this->save([
            'user_id' => $userId,
            'knowledge' => $knowledgeId
        ]);
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
