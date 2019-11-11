<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function show(Category $category, Request $request, Topic $topic)
    {
        // 读取分类 ID 关联的话题，并按每 20 条分页
        $topics = $topic->withOrder($request->order)
                        ->where('category_id', $category->id)
                        ->paginate(20);
        // 传参变量到模板中
        return view('topics.index', compact('topics', 'category'));
    }
}
// 返回用户头像 名字等信息， 话题信息，话题的分类信息
// public function show(Request $request,Category $category, Topic $topic)
// {
//     $topics = $topic->withOrder($request->order)
//                     ->where('category_id', '=', $category->id)
//                     ->paginate(30);
//     return view('topic.index', compact('topics'));
// }