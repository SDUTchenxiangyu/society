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
      
      <form class="form-signin" action="{{url('/signin')}}" method="post">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <h2 class="form-signin-heading">会员注册</h2>
        <label for="inputEmail" class="sr-only">学号</label>
        <input type="text" id="inputusenumber" name="number" class="form-control" placeholder="学号" required autofocus>
        <label for="inputEmail" class="sr-only">姓名</label>
        <input type="text" id="inputname" name="name" class="form-control" placeholder="姓名" required autofocus>
        <label for="inputEmail" class="sr-only">班级</label>
        <input type="text" id="inputsclass" name="sclass" class="form-control" placeholder="班级" required autofocus>
        <label for="inputEmail" class="sr-only">手机号</label>
        <input type="text" id="inputmphone" name="mphone" class="form-control" placeholder="手机号" required autofocus>
        <label for="inputPassword" class="sr-only">密码</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="密码" required>
        <button id="jgzjbutton" class="btn btn-lg btn-primary btn-block" type="submit">注册</button>
      </form>
@stop