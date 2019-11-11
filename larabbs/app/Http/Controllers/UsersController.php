<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function show(User $user)
    {

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();

        if ($request->avatar) {
            /* 如果用户修改了头像，那将上传头像*/
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }

    /**
     *  返回 话题的作者 和 评论此话题的作者
     */
    public function UserLikeSeach(Request $request)
    {
        $topic = \App\Models\Topic::find($request->topic_id); // 获得此话题实例

        $topic_user_name = $topic->user->name; //得到话题作者 （字符串）
        $topic_reply_user_name = $topic->replies->map(function ($reply){
                return $reply->user->name;
            })->unique(); // map 循环   unique（）返回集合中的唯一数据项
        $names = $topic_reply_user_name->prepend($topic_user_name); //prepend() :添加数据到开头
  
        return $names;
    }
}
