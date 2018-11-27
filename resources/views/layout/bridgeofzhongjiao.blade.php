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
      <form class="form-signin" action="{{url('/tamebaoming')}}" method="post">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="match" value="13">
        <h2 class="form-signin-heading">中交桥梁设计大赛报名</h2>
        <label for="inputEmail" class="sr-only">队员1学号</label>
        <input type="text" id="inputusenumber" name="peopleone" class="form-control" placeholder="队员1学号" required autofocus>
        <br>
        <label for="inputEmail" class="sr-only">队员2学号</label>
        <input type="text" id="inputusenumber" name="peopletwo" class="form-control" placeholder="队员2学号" required autofocus>
        <br>
        <button id="jgzjbutton" class="btn btn-lg btn-primary btn-block" type="submit">报名</button>
      </form>
@stop