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
use App\Tame;
use App\Cad;
use Excel;
//定义全局变量regexp_url用于之后对url进行正则匹配
global $regexp_url;
//正则表达式匹配完会有一个带有六个数组元素的一维数组，数组第0个是完整网址，第1，2个是协议名，第3，4个是一级目录名，第五个是二级目录名
$regexp_url = '~^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?~i';

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
        //代码验证部分
        $input = $request->all();
        $rules =  [
            'number' => 'required|numeric',
            'name' => 'required|string',
            'sclass' => 'required|string',
            'mphone' => 'required|numeric',
            'password' => 'required',
        ];
        $messages = [
            'number.required' => '学号不能为空！',
            'number.numeric' => '学号栏不得填写数字以外的符号！',
            'name.require' => '姓名不能为空！',
            'name.string' => '姓名不能填写非法字符！',
            'sclass.require' => '班级不能为空！',
            'sclass.string' => '班级不能填写非法字符！',
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
        $ymphone = "/1[34578]\d{9}/";
        preg_match ($ymphone,$input['mphone'],$pth);
        if(!$pth)
        {
            return redirect('signin')->with('err',"手机号码不正确！");
        }
        $huiyuan = new Huiyuan;
        //验证会员表中是否已经有用户的信息        
        $huiyuan_yanzheng = $huiyuan->where('number',$input['number'])->first();
        if($huiyuan_yanzheng)
        {
            return redirect('signin')->with('err',"用户已存在");
        }
        //入库操作
        $huiyuan->name = $input['name'];
        $huiyuan->class = $input['class'];
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
        //从会员表中查询是否存在该用户
        $chaxunyanzheng = $chaxunyanzheng->where('number',$input['number'])->first();
        if(!$chaxunyanzheng)
        {
            return redirect('signup')->with('err',"无此用户！");
        }
        //验证密码
        $password = $chaxunyanzheng['password'];
        if($password!=$input['password'])
        {
            return redirect('signup')->with('err',"密码不正确！");
        }
        //写入浏览器session
        $number = $input['number'];
        $name = $chaxunyanzheng['name'];
        session(['number' => $number]);
        session(['name' => $name]);
        return redirect('/');
    }
    //登出控制器
    public function signout(Request $request)
    {
        $request->session()->forget('number');
        $request->session()->forget('name');
        return redirect('/');
    }
    //报名表整理界面
    public function table()
    {
        return view('admin.table');
    }
    //报名表整理
    public function houtai(Request $request)
    {
        global $regexp_url;
        //检查session中是否存在学号
        if(!session()->has('number'))
        {
            return redirect('signup')->with('err','您未登陆，请先登陆');
        }
        $input = $request->all();
        //获取用户上一个页面的url地址
        $path = url()->previous();
        //使用正则表达式将url地址分割，得到最后的二级url地址
        //正则表达式匹配
        preg_match ($regexp_url,$path,$pth);
        //从会员表，会员报名比赛表，比赛名称表取值
        $number = new Usermatch;
        $name = new Matchname;
        $nameofmatch = $name->where('id',$input['table'])->first();
        $tempnumber = $number->where('match',$input['table'])->get();
        //计算一共有多少人报名了比赛
        $matchnumber = $tempnumber->count();
        if($matchnumber==0&&$input['table']!=11)
        {
            return redirect($pth[5])->with('err','本项比赛没有用户报名！');
        }
        if($input['table']!=11)
        {
            $cellData = $number->where('match',$input['table'])->get();
            $arr = array( array("id","姓名","手机号","班级","学号") ); 
            foreach($cellData as $tables)
            {   
                $huiyuan = new Huiyuan;
                $huiyuanchaxun = $huiyuan->where('number',$tables['number'])->first();
                $temp = array(array($tables['id'],$huiyuanchaxun['name'],$huiyuanchaxun['mphone'],$huiyuanchaxun['sclass'],$huiyuanchaxun['number']));
                $arr = array_merge($arr,$temp);
            }
            Excel::create($nameofmatch['name'].'比赛报名统计表',function($excel) use ($arr){
                $excel->sheet('score', function($sheet) use ($arr){
                    $sheet->rows($arr);
                });
            })->export('xls');
        }
        else
        {
            $tableofcad = new Cad;
            $cellData = $tableofcad->get();
            $arr = array( array("id","姓名","手机号","座号","年级","班级") );
            foreach($cellData as $tables)
            {
                $huiyuan = new Huiyuan;
                $huiyuanchaxun = $huiyuan->where('number',$tables['number'])->first();
                $numberofcad = new Cad;
                $dataofcad = $numberofcad->where('number',$tables['number'])->first();
                $temp = array(array($tables['id'],$huiyuanchaxun['name'],$huiyuanchaxun['mphone'],$dataofcad['power'],$dataofcad['level'],$huiyuanchaxun['sclass']));
                $arr = array_merge($arr,$temp);
            } 
            Excel::create('CAD技能大赛座号统计表',function($excel) use ($arr){
                $excel->sheet('score', function($sheet) use ($arr){
                    $sheet->rows($arr);
                });
            })->export('xls');
        }
        // for($i=1;$matchnumber>=$i;$i++)
        // {
        //     $baomingbiao = new Baomingbiao;
        //     $numbertemp = $number->where('id',$i)->first();
        //     $nametemp = $name->where('id',$numbertemp['match'])->first();
        //     $huiyuantemp = $huiyuan->where('number',$numbertemp['number'])->first();
        //     $baomingbiao->name = $huiyuantemp['name'];
        //     $baomingbiao->mphone = $huiyuantemp['mphone'];
        //     $baomingbiao->matchnum = $numbertemp['match'];
        //     $baomingbiao->matchname = $nametemp['name'];
        //     $baomingbiao->save();
        // }
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
        if($count)
        {
            return view('welcome',['matchopen'=>$matchopen]);
        }
        else
        {
            return view('welcome');
        }
    }
    //社团后台登陆界面
    public function self()
    {
        return view('admin.power');
    }
    //社团后台登陆入口
    public function power(Request $request)
    {
        global $regexp_url;
        if(!session()->has('number'))
        {
            return redirect('signup')->with('err','您未登陆，请先登陆');
        }
        //获取用户上一个页面的url地址
        $path = url()->previous();
        //使用正则表达式将url地址分割，得到最后的二级url地址
        //正则表达式匹配
        preg_match ($regexp_url,$path,$pth);
        $input = $request->input();
        $power = new Power;
        $session = session()->all();
        $password = $power->where('number',$session['number'])->first();
        if($password['password']==$input['password'])
        {
            return redirect('houtai')->with('success',"已成功登陆，欢迎你，社团的贡献者！");
        }
        else
        {
            return redirect($pth[5])->with('err',"密码不正确！");
        }
    }
    public function houtaiinto()
    {
        return view('admin.houtai');
    }
}
