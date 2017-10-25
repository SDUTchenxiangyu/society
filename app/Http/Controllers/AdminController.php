<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Huiyuan;

class AdminController extends Controller
{
    // get方式注册
    public function signin()
    {
        return view('admin.login');
    }
    // get方式登陆
    public function signup()
    {
        return view('admin.signup');
    }
    // post方式注册
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
        $huiyuan = new Huiyuan;
        $huiyuan_yanzheng = $huiyuan->where('number',$input['number'])->first();
        if($huiyuan_yanzheng)
        {
            return redirect('signin')->with('err',"用户已存在");
        }
        $huiyuan->name = $input['name'];
        $huiyuan->number = $input['number'];
        $huiyuan->mphone = $input['mphone'];
        $huiyuan->password = $input['password'];
        if($huiyuan->save())
        {
            return redirect('signup')->with('success',$input['name']);
        }
        else
        {
            return redirect('signin')->with('err','系统故障，注册失败，请稍后再试！');
        }
    }
    // post方式登陆
    public function ysignup(Request $request)
    {
        $input = $request->all();
        dd($input);
    }
}
