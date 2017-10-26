<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Huiyuan;
use App\Matchname;
use App\Usermatch;
use App\Http\Requests;

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
        echo "这是详情页！";
    }
    public function baoming(Request $request)
    {
        $session = session()->all();
        $input = $request->input();
        $match = new Usermatch;
        $matchy = $match->where('number',$session['number'])->where('match',$input['match'])->first();
        if($matchy['match'])
        {
            return redirect('chengtu')->with('err','您已报名，请勿重复报名');
        }
        $match->match = $input['match'];
        $match->number = $session['number'];
        if($match->save())
        {
            return redirect('chengtu')->with('success',$session['name']);
        } 
        else
        {
            return redirect('chengtu')->with('err','系统故障，注册失败，请稍后再试！');
        }
    }
}
