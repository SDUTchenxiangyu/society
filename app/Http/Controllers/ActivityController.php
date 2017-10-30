<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Huiyuan;
use App\Matchname;
use App\Usermatch;
use App\Http\Requests;
use App\Tame;

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
        //纸牌搭楼
        return view('layout.poker');
    }
    public function bridge()
    {
        //纸桥承重
        return view('layout.bridge');
    }
    public function more()
    {
        //详情页
        if(!session()->has('number'))
        {
            return redirect('signup')->with('err','您未登陆，请先登陆');
        }
        $session = session()->all();
        $match = new Usermatch;
        
        $match = $match->where('number',$session['number'])->get();
        $user = [];
        foreach($match as $matchs)
        {
            $username = $session['name'];
            $name = new Matchname;
            $name = $name->where('id',$matchs['match'])->first();
            $user = array_prepend($user,$name);
        }
        return view('layout.more',['users'=>$user]);
    }
    public function baoming(Request $request)
    {
        if(!session()->has('number'))
        {
            return redirect('signup')->with('err','您未登陆，请先登陆');
        }
        $path = url()->previous();
        $re = '~^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?~i';
        preg_match ($re,$path,$pth);
        $session = session()->all();
        $input = $request->input();
        $match = new Usermatch;
        $matchy = $match->where('number',$session['number'])->where('match',$input['match'])->first();
        if($matchy['match'])
        {
            return redirect($pth[5])->with('err','您已报名，请勿重复报名');
        }
        $match->match = $input['match'];
        $match->number = $session['number'];
        if($match->save())
        {
            return redirect($pth[5])->with('success',$session['name']);
        } 
        else
        {
            return redirect($pth[5])->with('err','系统故障，注册失败，请稍后再试！');
        }
    }
    public function tamebaoming(Request $request)
    {
        if(!session()->has('number'))
        {
            return redirect('signup')->with('err','您未登陆，请先登陆');
        }
        $path = url()->previous();
        $re = '~^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?~i';
        preg_match ($re,$path,$pth);
        $input = $request->input();
        $usermatch = new Usermatch;
        $session = session()->all();
        $userone = $usermatch->where('match',$input['match'])->where('number',$input['peopleone'])->get();
        if(isset($userone['match']))
        {
            return redirect($pth[5])->with('err','队员1已报名，请勿重复报名');
        }
        $usertwo = $usermatch->where('match',$input['match'])->where('number',$input['peopletwo'])->get();
        if(isset($usertwo['match']))
        {
            return redirect($pth[5])->with('err','队员2已报名，请勿重复报名');
        }
        $matchy = $usermatch->where('number',$session['number'])->where('match',$input['match'])->first();
        if(isset($matchy['match']))
        {
            return redirect($pth[5])->with('err','您已报名，请勿重复报名');
        }
        $tame = new Tame;
        $tame = $tame->count();

        // $re = '/(\w*)+/';
        
        for($i=0;$i<1;$i++)
        {
            $match1 = new Usermatch;
            $match1->match = $input['match'];
            $match1->number = $session['number'];
            $match1->tame = $tame+1;
            $match2 = new Usermatch;
            $match2->match = $input['match'];
            $match2->number = $input['peopleone'];
            $match2->tame = $tame+1;
            $match3 = new Usermatch;
            $match3->match = $input['match'];
            $match3->number = $input['peopletwo'];
            $match3->tame = $tame+1;
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
}
