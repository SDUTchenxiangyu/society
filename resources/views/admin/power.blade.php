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
      <form class="form-signin" action="{{url('/self')}}" method="post">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <h2 class="form-signin-heading">核心授权码验证</h2>
        <label for="inputPassword" class="sr-only">核心授权码</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="核心授权码" required>
        <button id="jgzjbutton" class="btn btn-lg btn-primary btn-block" type="submit">验证</button>
      </form>
@stop
