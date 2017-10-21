<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        
        
    }
}
