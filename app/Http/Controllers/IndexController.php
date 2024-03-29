<?php

namespace App\Http\Controllers;

use App\Models\Browse;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Help;
use App\Models\Knowledge;
use App\Models\Version;
use Illuminate\Http\Request;
use Qiniu\Auth;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\JWTAuth;

class IndexController extends Controller
{
    /**
     * 分类列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function category()
    {
        return response()->json([
            'status'=> true,
            'total' => Knowledge::getKnowledgeTotalNum(),
            'list'  => Category::getCategoryListByCache()
        ]);
    }

    /**
     * 知识点列表
     * @param $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function knowledge($categoryName)
    {
        return response()->json([
            'status'=> true,
            'list' => Knowledge::getKnowledgeListCacheByCategory($categoryName)
        ]);
    }

    /**
     * 知识点详情
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function knowledgeInfo($id)
    {
        $info = Knowledge::getKnowledgeInfo($id);
        if ($info) {
            return response()->json([
                'status'=> true,
                'data' => $info
            ]);
        } else {
            return response()->json([
                'status'=> false,
                'message' => '数据不存在'
            ]);
        }
    }

    /**
     * 收藏榜单
     * @return \Illuminate\Http\JsonResponse
     */
    public function rankList()
    {
        return response()->json([
            'status'=> true,
            'list' => Knowledge::getCollectionList()
        ]);
    }

    /**
     * 搜索
     * @param $keyword
     * @return \Illuminate\Http\JsonResponse
     */
    public function search($keyword)
    {
        $data = Knowledge::where('question', 'like', "%$keyword%")->limit(50)->get(['id', 'question']);
        return response()->json([
            'status'=> true,
            'list' => $data
        ]);
    }

    /**
     * 版本信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function version()
    {
        return response()->json([
            'status'=>true,
            'list' => Version::getVersionList()
        ]);
    }

    /**
     * 帮助中心
     */
    public function help()
    {
        return response()->json([
            'status'=> true,
            'list' => Help::getHelpList()
        ]);
    }
}
