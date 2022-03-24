<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Points extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    /**
     * 添加用户积分
     * @param $userId
     * @param int $points
     * @return bool
     */
    public function addMemberPoint($userId, $points = 0)
    {
        //添加记录
        $this->save([
            'user_id' => $userId,
            'type'      => 1,//添加
            'points'    => $points,
        ]);

        //修改用户表积分
        DB::table('user')->where('id', '=', $userId)->increment('points', $points);

        return true;
    }
}
