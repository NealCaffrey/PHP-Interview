<?php
/**
 * Created by PhpStorm
 * User: Neal Caffrey
 * Date: 3/23/2022
 * Time: 10:55 AM
 */

namespace App\Http\Controllers;


use App\Models\Browse;
use App\Models\Collection;
use App\Models\Help;
use App\Models\Member;
use App\Models\Question;
use App\Models\Sign;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * @var $memberId
     */
    protected $memberId;

    /**
     * @var $token
     */
    protected $token;

    public function __construct(Request $request)
    {
        $this->token = $request->header('token');
        $memberInfo = Redis::get('member:cache:');
    }

    /**
     * 用户信息
     * @param $memberId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMemberInfo($memberId)
    {
        return response()->json([
            'status' => true,
            'data' => Member::find($memberId)
        ]);
    }

    /**
     * 收藏数据
     * @param $memberId
     * @param $knowledgeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function collection($memberId, $knowledgeId)
    {
        $collection = new Collection();
        return response()->json([
            'status'=> $collection->memberCollectionKnowledge($memberId, $knowledgeId)
        ]);
    }

    /**
     * 用户收藏列表
     * @param $memberId
     * @return \Illuminate\Http\JsonResponse
     */
    public function collectionList($memberId)
    {
        return response()->json([
            'status'=> true,
            'list' => Collection::getMemberCollectionList($memberId)
        ]);
    }

    /**
     * 用户浏览列表
     * @param $memberId
     * @return \Illuminate\Http\JsonResponse
     */
    public function browseList($memberId)
    {
        return response()->json([
            'status'=> true,
            'list' => Browse::getMemberBrowseList($memberId)
        ]);
    }

    /**
     * 签到
     */
    public function sign($memberId)
    {
        $signModel = new Sign();
        $signDay = date('Y-m-d');
        $check = $signModel->checkIsSign($memberId, $signDay);
        if ($check) {
            return response()->json([
                'status' => false,
                'errors' => '今天已经签到'
            ]);
        }

        return response()->json([
            'status' => $signModel->memberSign($memberId, $signDay),
        ]);
    }

    /**
     * 生成试卷
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateExam(Request $request)
    {
        //参数验证
        $validator = Validator::make($request->all(), [
            'auto_switch'   => 'required|integer|between:0,1',
            'question_num'  => 'required|integer|between:10,100',
            'pattern'       => 'required|integer|between:1,2',
            'category_id'   => 'required'
        ]);
        if ($validator->errors()->first()) {
            return response()->json($validator->errors()->first());
        }

        $categoryIds = explode(',', $request->input('category_id'));
        $number = $request->input('question_number', 10);
        $pattern = $request->input('pattern', 1);
        return response()->json([
            'status'=>true,
            'list' => Question::generateExam($categoryIds, $number, $pattern)
        ]);
    }
}
