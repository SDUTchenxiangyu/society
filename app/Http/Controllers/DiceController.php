<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Huiyuan;
use App\Matchname;
use App\Usermatch;
use App\Tame;
use App\Dice;

class DiceController extends Controller
{
    public function index()
    {
        return view('layout.dice');
    }
    public function cindex()
    {
        return view('layout.dicechouqian');
    }
    public function yanzheng(Request $request)
    {
        if(!session()->has('number'))
        {
            return redirect('signup')->with('err','您未登陆，请先登陆');
        }
        $path = url()->previous();
        $re = '~^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?~i';
        preg_match ($re,$path,$pth);
        $input = $request->input();
        $matchname = new Matchname;
        $matchname = $matchname->where('id',$input['match'])->first();
        if(!$matchname['open'])
        {
            return redirect($pth[5])->with('err','本项比赛尚未开放报名！');
        }
        $usermatch = new Usermatch;
        $session = session()->all();
        $yusermatch = new Huiyuan;
        $yusermatch1 = $yusermatch->where('number',$input['peopleone'])->first();
        // dd($yusermatch1);
        if($yusermatch1==null)
        {
            return redirect($pth[5])->with('err','队员1未注册，请队员1先完成网站注册');
        }
        $yusermatch2 = $yusermatch->where('number',$input['peopletwo'])->first();
        if($yusermatch2==null)
        {
            return redirect($pth[5])->with('err','队员2未注册，请队员2先完成网站注册');
        }
        $yusermatch3 = $yusermatch->where('number',$input['peoplethree'])->first();
        if($yusermatch3==null)
        {
            return redirect($pth[5])->with('err','队员3未注册，请队员2先完成网站注册');
        }
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
        $userthree = $usermatch->where('match',$input['match'])->where('number',$input['peoplethree'])->get();
        if(isset($usertwo['match']))
        {
            return redirect($pth[5])->with('err','队员3已报名，请勿重复报名');
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
            $match4 = new Usermatch;
            $match4->match = $input['match'];
            $match4->number = $input['peoplethree'];
            $match4->tame = $tame+1;
            if($match1->save()&&$match2->save()&&$match3->save()&&$match4->save())
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
    public function chouqian(Request $request)
    {
        if(!session()->has('number'))
        {
            return redirect('signup')->with('err','您未登陆，请先登陆');
        }
        $path = url()->previous();
        $re = '~^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?~i';
        preg_match ($re,$path,$pth);
        $input = $request->input();
        $matchname = new Matchname;
        $session = session()->all();
        $matchname = $matchname->where('id',$input['match'])->first();
        if(!$matchname['open'])
        {
            return redirect($pth[5])->with('err','本项比赛尚未开始抽签！');
        }
        $usermatch = new Usermatch;
        $jiance = new Dice;
        $jiance = $jiance->where('number',$session['number'])->first();
        if($jiance != null)
        {
            return redirect($pth[5])->with('success',"您的队伍的号码是".$jiance['number']);
        }
        $tamecount = $usermatch->where('match',9)->count();
        $tame = $tamecount/4;
        $number = rand(1,$tame);
        for($i=1;$i<999;$i++)
        {
            $yanzheng = new Dice;
            $yes = $yanzheng->where('power',$number)->first();
            if($yes==null)
            {
                break;
            }
            $number = rand(1,$tame);
        }
        $power = new Dice;
        
        $user = new Huiyuan;
        $users = $user->where('number',$session['number'])->first();
        $user1 = new Huiyuan;
        $userss1 = new Usermatch;
        $tamenumber = $userss1->where('match',9)->where('number',$session['number'])->first();
        if($tamenumber == null)
        {
            return redirect($pth[5])->with('err','您未参加本项比赛！');
        }
        $tamenumber = $tamenumber['tame'];
        $users1 = $userss1->where('tame',$tamenumber)->get();
        foreach($users1 as $usersss)
        {
            $user11 = new Huiyuan;
            $user111 = new Dice;
            $users1111 = $user11->where('number',$usersss['number'])->first();
            $user111->name = $users1111['name'];
            $user111->phone = $users1111['mphone'];
            $user111->tame = $tamenumber;
            $user111->power = $number;
            $user111->number = $users1111['number'];
            $user111->save();
        }
        return redirect($pth[5])->with('success',"您的队伍的号码是".$number);
    }
}
