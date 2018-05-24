@extends('mould.app')
@section('content')
    @if($errors->first())
        <div class="alert alert-danger alert-dismissible" id="alertjgzj" role="alert">
            <button type="button" id="myAlert" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>警告,</strong>{{$errors->first()}}
        </div>
        @endif
        @if(Session::has('err'))
        <div class="alert alert-danger alert-dismissible" id="alertjgzj" role="alert">
            <button type="button" id="myAlert" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>警告,</strong>{{Session::get('err')}}
        </div>
        @endif
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible" id="alertjgzj" role="alert">
            <button type="button" id="myAlert" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>恭喜你,{{Session::get('success')}}</strong>
        </div>
        @endif
        <form class="form-signin" action="{{url('/table')}}" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <h2 class="form-signin-heading">请选择要打印的表格</h2>
            <label for="inputPassword" class="sr-only">核心授权码</label>
            <select name="table" class="form-control">
                <option value="1">纸桥承重比赛报名表</option>
                <option value="2">纸牌搭楼比赛报名表</option>
                <option value="3">CAD技能大赛报名表</option>
                <option value="4">结构设计大赛报名表</option>
                <option value="5">建筑之美报名表</option>
                <option value="6">成图大赛报名表</option>
                <option value="7">BIM软件算量报名表</option>
                <option value="8">BIM沙盘模拟报名表</option>
                <option value="11">CAD技能大赛抽签表</option> 
                <option value="12">桥举千斤报名表</option>                                                
            </select>
            <br>
            <button id="jgzjbutton" class="btn btn-lg btn-primary btn-block" type="submit">打印</button>
        </form>
@stop