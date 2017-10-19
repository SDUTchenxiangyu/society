<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PhotoController extends Controller
{
    public function index()
    {
        echo "这里是比赛风采页！";
        // view('');
    }
    public function content()
    {
        echo "这是内容展示页！";
    }
}
