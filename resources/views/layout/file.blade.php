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
    <form method="post" enctype="multipart/form-data" action="{{url('/file')}}"> 
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">   
        <input type="file"  class="btn btn-lg btn-primary btn-block" name="picture">
        <br>
        <button type="submit" class="btn btn-lg btn-primary btn-block"> 提交 </button>
    </form>
@stop