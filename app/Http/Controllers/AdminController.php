<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;

class AdminController extends Controller
{
    public function signin()
    {
        return view('admin.login');
    }
    public function signup()
    {
        echo "这是登录界面";
    }
    public function ysignin(Request $request)
    {
        
        $input = $request->all();
        $rules =  [
            'number' => 'required|numeric',
            'name' => 'required|string',
            'mphone' => 'required|numeric',
            'password' => 'required',
        ];
        $messages = [
            'number.required' => '学号不能为空！',
            'number.numeric' => '学号栏不得填写数字以外的符号！',
            'name.require' => '姓名不能为空！',
            'name.string' => '姓名不能填写非法字符！',
            'mphone.require' => '手机号不能为空！',
            'mphone.numeric' => '手机号不得填写数字以外的符号！',
            'password.required' => '密码不能为空！',
        ];
        $validator = Validator::make($input, $rules, $messages);
        if($validator->errors()->all())
        {
            return redirect('signin')
                ->withErrors($validator)
                ->withInput();
        }
    }
}
