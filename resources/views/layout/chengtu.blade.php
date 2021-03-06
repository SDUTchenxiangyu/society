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
            <strong>恭喜你,{{Session::get('success')}}</strong>，报名成功！
        </div>
      @endif
      <form class="form-signin" action="{{url('/baoming')}}" method="post">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="match" value="6">
        <h2 class="form-signin-heading">成图大赛报名</h2>
        <br>
        <label for="inputEmail" class="sr-only">班级</label>
        <input type="text" id="inputsclass" name="sclass" class="form-control" placeholder="班级" required autofocus>
        <br>
		<h4 class="form-signin-heading">选择方向</h4>
        <select name="table" class="form-control">
            <option value="1">道桥方向</option>
            <option value="2">房建方向</option>                                               
        </select>
		<br>
        <button id="jgzjbutton" class="btn btn-lg btn-primary btn-block" type="submit">报名</button>
        <a class="btn btn-lg btn-primary btn-block" href="{{url('/file')}}" role="button">作品提交</a>
      </form>
@stop
