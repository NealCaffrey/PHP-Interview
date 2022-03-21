<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Knowledge;
use App\Models\Question;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data = Category::all();
        foreach ($data as $k => $v) {
            $data[$k]->image = env('APP_URL') . $v->image;
        }

        return response()->json($data);
    }

    public function knowledge(Request $request)
    {
        $categoryId = $request->input('category_id', 0);
        $data = Knowledge::where('category_id', '=', $categoryId)->get()->toArray();

        return response()->json($data);
    }

    public function knowledgeInfo(Request $request)
    {
        $data = Knowledge::with('category')->find($request->input('id'));

        return response()->json($data);
    }
}
