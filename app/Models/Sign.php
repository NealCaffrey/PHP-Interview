<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Sign extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'sign';

    /**
     * 检测是否签到
     * @param $userId
     * @param $signDay
     * @return bool
     */
    public function checkIsSign($userId, $signDay)
    {
        $check = $this->where('user_id', '=', $userId)->where('sign_day', '=', $signDay)->first();
        return $check ? true : false;
    }

    /**
     * 用户签到
     * @param $userId
     * @param $signDay
     * @return string
     */
    public function memberSign($userId, $signDay)
    {
        //添加签到记录
        $res = $this->save([
            'user_id' => $userId,
            'sign_day'  => $signDay
        ]);

        if ($res) {
            //添加积分
            $point = new Points();
            $point->addMemberPoint($userId, 10);
        }

        return $res;
    }
}
