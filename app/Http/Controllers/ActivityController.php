<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Huiyuan;
use App\Matchname;
use App\Usermatch;
use App\Http\Requests;
use App\Tame;
use App\Cad;
use Storage;
use DB;
//定义全局变量regexp_url用于之后对url进行正则匹配
global $regexp_url;
//正则表达式匹配完会有一个带有六个数组元素的一维数组，数组第0个是完整网址，第1，2个是协议名，第3，4个是一级目录名，第五个是二级目录名
$regexp_url = '~^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?~i';

class ActivityController extends Controller
{
    public function chengtu()
    {
        //高教杯成图大赛
        return view('layout.chengtu');
    }
    public function jiegou()
    {
        //结构设计大赛
        return view('layout.jiegou');
    }
    public function bimsoft()
    {
        //BIM软件算量大赛
        return view('layout.bimsoft');
    }
    public function bimgrass()
    {
        //BIM沙盘模拟大赛
        return view('layout.bimgrass');
    }
    public function cadstill()
    {
        //CAD技能大赛
        return view('layout.cadstill');
    }
    public function building()
    {
        //建筑之美
        return view('layout.building');
    }
    public function poker()
    {
        global $chenxiangyu;
        dd($chenxiangyu);
        //纸牌搭楼
        return view('layout.poker');
    }
    public function bridge()
    {
        //纸桥承重
        return view('layout.bridge');
    }
    //此控制器用于连接/more页面，用于为用户提供报名后显示出比赛的相关信息
    public function more()
    {
        //详情页
        if(!session()->has('number'))
        {
            //如果session里不存在“number”那么就将用户返回登陆页
            return redirect('signup')->with('err','您未登陆，请先登陆');
        }
        $session = session()->all();
        //获取一个用户报名比赛的表实例
        $match = new Usermatch;
        //用session里的number值来查询用户报名比赛表里的比赛
        $match = $match->where('number',$session['number'])->get();
        //创建一个空数组
        $user = [];
        foreach($match as $matchs)
        {
            $username = $session['name'];
            //创建一个比赛名称的表实例
            $name = new Matchname;
            //用之前查询用户报名比赛的表中查到的用数字代替比赛类型的用户报名情况查询比赛名称表中对应的真实比赛名称
            $name = $name->where('id',$matchs['match'])->first();
            //将查到的比赛信息添加到user变量中
            $user = array_prepend($user,$name);
        }
        return view('layout.more',['users'=>$user]);
    }
    //报名的总控制器，其中包含了全套的认证、入库相关操作
    public function baoming(Request $request)
    {
        global $regexp_url;
        if(!session()->has('number'))
        {
            //如果session里不存在“number”那么就将用户返回登陆页
            return redirect('signup')->with('err','您未登陆，请先登陆');
        }
        //获取用户上一个页面的url地址
        $path = url()->previous();
        //使用正则表达式将url地址分割，得到最后的二级url地址
        //正则表达式匹配
        preg_match ($regexp_url,$path,$pth);
        $session = session()->all();
        //获取提交值中的全部信息，其中应该包括，比赛名称代号
        $input = $request->input();
        //创建一个比赛名称表实例
        $matchname = new Matchname;
        //使用request中的比赛代号查询比赛名称表中的相关比赛
        $matchname = $matchname->where('id',$input['match'])->first();
        //检查比赛是否开放
        if(!$matchname['open'])
        {
            return redirect($pth[5])->with('err','本项比赛尚未开放报名！');
        }
        //创建一个用户报名比赛表实例
        $match = new Usermatch;
        //查询用户报名比赛表中，用户学号是否报名了这个比赛
        $matchy = $match->where('number',$session['number'])->where('match',$input['match'])->first();
        if($matchy['match'])
        {
            return redirect($pth[5])->with('err','您已报名，请勿重复报名');
        }
        //准备入库
        $inspectforclass = new Huiyuan;
        $inspectforclassstring = $inspectforclass->where('number',$session['number'])->first();
        if(!$inspectforclassstring['sclass'])
        {
            $update = DB::table('huiyuan')->where('number', $session['number'])->update(['sclass' => $input['sclass']]);
        }
        if(isset($input['table']))
        {
            $match->match = $input['match'];
            $match->number = $session['number'];
            $match->optional = $input['table'];
        }
        else
        {
            $match->match = $input['match'];
            $match->number = $session['number'];
        }
        if($match->save())
        {
            return redirect($pth[5])->with('success',$session['name']);
        } 
        else
        {
            return redirect($pth[5])->with('err','系统故障，注册失败，请稍后再试！');
        }
    }
    //团队报名控制器，基本与上面的个人控制器一致
    public function tamebaoming(Request $request)
    {
        global $regexp_url;
        if(!session()->has('number'))
        {
            //如果session里不存在“number”那么就将用户返回登陆页
            return redirect('signup')->with('err','您未登陆，请先登陆');
        }
        //获取用户上一个页面的url地址
        $path = url()->previous();
        //使用正则表达式将url地址分割，得到最后的二级url地址
        //正则表达式匹配
        preg_match ($regexp_url,$path,$pth);
        //获取request中的全部值，其中应该包括：队员1，2，3的学号，比赛代码
        $input = $request->input();
        //创建比赛名称表实例
        $matchname = new Matchname;
        // 查询比赛代码对应的比赛信息
        $matchname = $matchname->where('id',$input['match'])->first();
        //判断比赛是否开放
        if(!$matchname['open'])
        {
            return redirect($pth[5])->with('err','本项比赛尚未开放报名！');
        }
        // 创建用户报名比赛表实例
        $usermatch = new Usermatch;
        $session = session()->all();
        //创建用户总表实例
        $yusermatch = new Huiyuan;
        //查询用户总表的队员1
        $yusermatch1 = $yusermatch->where('number',$input['peopleone'])->first();
        //查询用户总表中的队员2
        $yusermatch2 = $yusermatch->where('number',$input['peopletwo'])->first();
        // dd($yusermatch1);
        //判断队员1是否注册
        if($yusermatch1==null)
        {
            return redirect($pth[5])->with('err','队员1未注册，请队员1先完成网站注册');
        }
        //判断队员2是否注册
        if($yusermatch2==null)
        {
            return redirect($pth[5])->with('err','队员2未注册，请队员2先完成网站注册');
        }
        //判断用户是否已经报名比赛
        $matchy = $usermatch->where('number',$session['number'])->where('match',$input['match'])->first();
        //查询队员1是否已经报名该比赛
        $userone = $usermatch->where('match',$input['match'])->where('number',$input['peopleone'])->get();
        //查询队员2是否已经报名该比赛
        $usertwo = $usermatch->where('match',$input['match'])->where('number',$input['peopletwo'])->get();
        //判断用户是否报名比赛
        if(isset($matchy['match']))
        {
            return redirect($pth[5])->with('err','您已报名，请勿重复报名');
        }
        //判断队员1是否报名比赛
        if(isset($userone['match']))
        {
            return redirect($pth[5])->with('err','队员1已报名，请勿重复报名');
        }
        //判断队员2是否报名比赛
        if(isset($usertwo['match']))
        {
            return redirect($pth[5])->with('err','队员2已报名，请勿重复报名');
        }
        //创建队伍表实例
        $tame = new Tame;
        //计算队伍表人数数量
        $tame = $tame->count();

        // $re = '/(\w*)+/';
        //这个循环为什么要加？就只循环一次，明明就是你乱用数组key值，现在傻眼了吧233333
        for($i=0;$i<1;$i++)
        {
            //队长信息
            $match1 = new Usermatch;
            $match1->match = $input['match'];
            $match1->number = $session['number'];
            $match1->tame = $tame+1;
            //队员一信息
            $match2 = new Usermatch;
            $match2->match = $input['match'];
            $match2->number = $input['peopleone'];
            $match2->tame = $tame+1;
            //队员二信息
            $match3 = new Usermatch;
            $match3->match = $input['match'];
            $match3->number = $input['peopletwo'];
            $match3->tame = $tame+1;
            //入库操作，并在队伍表中登记信息，若都成功，则返回，若不成功，则返回之前操作页
            if($match1->save()&&$match2->save()&&$match3->save())
            {
                $tamematch = new Tame;
                $tamematch->number = $session['number'];
                if($tamematch->save())
                {
                    return redirect($pth[5])->with('success',$session['name']);
                }
                else
                {
                    return redirect($pth[5])->with('err','系统故障，注册失败，请稍后再试！');
                }
            } 
            else
            {
                return redirect($pth[5])->with('err','系统故障，注册失败，请稍后再试！');
            }
        }
    }
    //CAD技能大赛抽取座号，用随机数生成，必须等报名结束后才能生成
    public function cadchouqian()
    {
        global $regexp_url;
        //检查session中是否存在学号
        if(!session()->has('number'))
        {
            return redirect('signup')->with('err','您未登陆，请先登陆');
        }
        //获取全部session信息
        $session = session()->all();
        //正则表达式匹配网址
        $path = url()->previous();
        preg_match ($regexp_url,$path,$pth);
        //从比赛信息表中查询比赛是否开启，是否可以抽签
        $matchname = new Matchname;
        $matchname = $matchname->where('id',11)->first();
        if(!$matchname['open'])
        {
            return redirect($pth[5])->with('err','本项比赛尚未开始抽签！');
        }
        //检查用户是否已经报名
        $tamenumber = $usermatch->where('match',3)->where('number',$session['number'])->first();
        if($tamenumber == null)
        {
            return redirect($pth[5])->with('err','您未参加本项比赛！');
        }
        //检查用户是否已经抽出了座号，若抽出了座号，则将库中的座号反馈给用户
        $jiance = new Cad;
        $jiance = $jiance->where('number',$session['number'])->first();
        if($jiance != null)
        {
            return redirect($pth[5])->with('success',"您的座号是".$jiance['power']);
        }
        //抽取座号，先检查有多少人报名CAD技能大赛，按照一到报名人数随机给出号码
        $usermatch = new Usermatch;
        $count = $usermatch->where('match',3)->count();
        $number = rand(1,$count);
        //按照用户学号信息查询是多少级的学生
        $level = (int)substr($session['number'],0,2);
        //防止抽到一样的座号，进行999次循环，反复抽取号码，直到库里没有该号码停止
        for($i=1;$i<999;$i++)
        {
            $yanzheng = new Cad;
            $yes = $yanzheng->where('power',$number)->first();
            if($yes==null)
            {
                break;
            }
            $number = rand(1,$count);
        }
        //验证无误，从会员表里取出会员信息
        $user = new Huiyuan;
        $users = $user->where('number',$session['number'])->first();
        //向座号表里存入信息
        $input = new Cad;
        $input->name = $users['name'];
        $input->phone = $users['mphone'];
        $input->power = $number;
        $input->number = $session['number'];
        $input->level = $level;
        if($input->save())
        {
            return redirect($pth[5])->with('success',"您的座号是".$number."。您的比赛等级为：".$level."级组。");
        }
        else
        {
            return redirect($pth[5])->with('err','系统故障！');
        }
        
    }
    //CAD技能大赛文件提交页面
    public function file()
    {
        return view('layout.file');
    }
    //CAD技能大赛文件提交系统
    public function upload(Request $request)
    {
        global $regexp_url;
        //查询用户是否登陆
        if(!session()->has('number'))
        {
            return redirect('signup')->with('err','您未登陆，请先登陆');
        }
        //从session中获取全部信息
        $session = session()->all();
        //正则表达式匹配网址
        $path = url()->previous();
        preg_match ($regexp_url,$path,$pth);
        //
        if ($request->isMethod('post')) 
        {
            $file = $request->file('picture');
            // 文件是否上传成功
            if(!$request->hasFile('picture'))
            {
                return redirect($pth[5])->with('err','未上传文件！');
            }
            if($file->isValid()) 
            {
                // 获取文件相关信息
                $originalName = $file->getClientOriginalName(); // 文件原名
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                $type = $file->getClientMimeType();     // image/jpeg
                // 上传文件
                $upiqid = uniqid();
                //命名为日期+文件原名+独有加密码+CAD后缀
                $filename = date('Y-m-d-H-i-s') . $originalName . '-' . $upiqid . '.' . $ext;
                // 使用我们新建的uploads本地存储空间（目录）
                $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
            }
        }
        return redirect($pth[5])->with('success',"提交成功,请保存您的唯一提交id：".$upiqid);
    }
}
