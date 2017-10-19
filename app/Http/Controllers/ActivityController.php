<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ActivityController extends Controller
{
    public function chengtu()
    {
        echo "这是成图大赛的页面！";
    }
    public function jiegou()
    {
        echo "这是结构设计大赛页面！";
    }
    public function bimsoft()
    {
        echo "这是BIM软件算量大赛页面！";
    }
    public function bimgrass()
    {
        echo "这是BIM沙盘模拟大赛页面！";
    }
    public function cadstill()
    {
        echo "这是CAD技能大赛页面！";
    }
    public function building()
    {
        echo "这是建筑之美比赛页面！";
    }
    public function poker()
    {
        echo "这是纸牌搭楼比赛页面！";
    }
    public function bridge()
    {
        echo "这是纸桥承重比赛页面！";
    }
}
