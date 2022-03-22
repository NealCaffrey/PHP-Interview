<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Knowledge;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    /**
     * 分类列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function category()
    {
        return response()->json([
            'total' => Knowledge::getKnowledgeTotalNum(),
            'list'  => Category::getCategoryListByCache()
        ]);
    }

    /**
     * 知识点列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function knowledge(Request $request)
    {
        return response()->json([
            'list' => Knowledge::getKnowledgeListCacheByCategory($request->input('category_id', 0))
        ]);
    }

    /**
     * 知识点详情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function knowledgeInfo(Request $request)
    {
        return response()->json([
            'data' => Knowledge::getKnowledgeInfo($request->input('id'))
        ]);
    }

    /**
     * 收藏榜单
     * @return \Illuminate\Http\JsonResponse
     */
    public function collection()
    {
        return response()->json([
            'list' => Knowledge::getCollectionList()
        ]);
    }

    /**
     * 搜索
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $data = Knowledge::where('question', 'like', "%{$request->input('keyword')}%")->limit(50)->get(['id', 'question']);
        return response()->json([
            'list' => $data
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
            'list' => Question::generateExam($categoryIds, $number, $pattern)
        ]);
    }
}
