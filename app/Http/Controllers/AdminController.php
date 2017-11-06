<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Huiyuan;
use App\Usermatch;
use App\Matchname;
use App\Baomingbiao;
use App\Power;

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
        $chaxunyanzheng = new Huiyuan;
        $chaxunyanzheng = $chaxunyanzheng->where('number',$input['number'])->first();
        if(!$chaxunyanzheng)
        {
            return redirect('signup')->with('err',"无此用户！");
        }
        $password = $chaxunyanzheng['password'];
        if($password!=$input['password'])
        {
            return redirect('signup')->with('err',"密码不正确！");
        }
        
        $number = $input['number'];
        $name = $chaxunyanzheng['name'];
        session(['number' => $number]);
        session(['name' => $name]);
        return redirect('/');
    }
    public function signout(Request $request)
    {
        $request->session()->forget('number');
        $request->session()->forget('name');
        return redirect('/');
    }
    public function houtai()
    {
        $number = new Usermatch;
        $huiyuan = new Huiyuan;
        $name = new Matchname;
        
        $matchnumber = $number->count();
        for($i=1;$matchnumber>=$i;$i++)
        {
            $baomingbiao = new Baomingbiao;
            $numbertemp = $number->where('id',$i)->first();
            $nametemp = $name->where('id',$numbertemp['match'])->first();
            $huiyuantemp = $huiyuan->where('number',$numbertemp['number'])->first();
            $baomingbiao->name = $huiyuantemp['name'];
            $baomingbiao->mphone = $huiyuantemp['mphone'];
            $baomingbiao->matchnum = $numbertemp['match'];
            $baomingbiao->matchname = $nametemp['name'];
            $baomingbiao->save();
        }
        return "报名表已整理完毕，请下载！";
    }
    public function welcome()
    {
        $match = new Matchname;
        $matchname = $match->where('open',1)->get();
        $count = $matchname->count();
        for($i=0;$i<$count;$i++)
        {
            $matchopen[$i] = $matchname[$i]['name'];
            // $session = session(["match[$i]"=>$matchname[$i]['name']]);
        }
        // $session = session()->push('mathc',$matchopen);
        return view('welcome',['matchopen'=>$matchopen]);
    }
    public function self()
    {
        return view('admin.power');
    }
    public function power(Request $request)
    {
        if(!session()->has('number'))
        {
            return redirect('signup')->with('err','您未登陆，请先登陆');
        }
        $input = $request->input();
        $power = new Power;
        $session = session()->all();
        $password = $power->where('number',$session['number'])->first();
        if($password['password']==$input['password'])
        {
            return redirect('self')->with('success',"已成功登陆，欢迎你，社团的贡献者！");
        }
        else
        {
            return redirect('signup')->with('err',"密码不正确！");
        }
    }
}
