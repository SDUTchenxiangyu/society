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
            <strong>恭喜你,{{Session::get('success')}}</strong>，注册成功！
        </div>
      @endif
      <form class="form-signin" action="{{url('/signup')}}" method="post">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <h2 class="form-signin-heading">会员登陆</h2>
        <label for="inputEmail" class="sr-only">学号</label>
        <input type="text" id="inputusenumber" name="number" class="form-control" placeholder="学号" required autofocus>
        <label for="inputPassword" class="sr-only">密码</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="密码" required>
        <button id="jgzjbutton" class="btn btn-lg btn-primary btn-block" type="submit">登陆</button>
      </form>
@stop
