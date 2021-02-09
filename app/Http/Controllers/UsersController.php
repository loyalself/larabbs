<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * laravel提供了【Auth】中间件来验证用户的身份，如果用户未通过身份验证，则 Auth 中间件会把用户重定向到登录页面
     * except: 除了某些方法不用经过中间件验证
     */
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
        $this->authorize('update',$user);
        return view('users.edit', compact('user'));
    }

    public function update(ImageUploadHandler $imageUploadHandler,UserRequest $request, User $user)
    {
        $this->authorize('update',$user);
        $data = $request->all();
        if($request->avatar){
            //max_width: 416 限制上传图片最大宽度
            $result = $imageUploadHandler->save($request->avatar, 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
