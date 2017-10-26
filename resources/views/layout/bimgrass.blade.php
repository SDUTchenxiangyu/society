<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>BIM沙盘模拟大赛</title>
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{url('/static/signin.css')}}" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url('http://www.sdut-jgzj.cn')}}">建工之家社团</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="{{url('/photo')}}">比赛风采</a></li>
              <li><a href="{{url('/content')}}">活动总览</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">具体活动<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class="dropdown-header">品牌活动</li>
                    <li><a href="{{url('/chengtu')}}">成图大赛</a></li>
                    <li><a href="{{url('/jiegou')}}">结构设计大赛</a></li>
                    <li><a href="{{url('/bimsoft')}}">BIM软件算量大赛</a></li>
                    <li><a href="{{url('/bimgrass')}}">BIM沙盘模拟大赛</a></li>
                    <li><a href="{{url('/cadstill')}}">CAD技能大赛</a></li>                    
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">会员活动</li>
                    <li><a href="{{url('/building')}}">建筑之美</a></li>
                    <li><a href="{{url('/poker')}}">纸牌搭楼</a></li>
                    <li><a href="{{url('/bridge')}}">纸桥承重</a></li>                    
                </ul>
              </li>
            </ul>
           
            <ul class="nav navbar-nav navbar-right">
            @if(Session::has('name'))
              <li><a href="#">{{Session::get('name')}}</a></li>
              <li><a href="{{url('/signout')}}">登出</a></li>
            @else
              <li><a href="{{url('/signup')}}">登陆</a></li>
              <li><a href="{{url('/signin')}}">注册</a></li>
            @endif
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
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
        <input type="hidden" name="match" value="8">
        <h2 class="form-signin-heading">BIM沙盘模拟大赛报名</h2>
        <br>
        <button id="jgzjbutton" class="btn btn-lg btn-primary btn-block" type="submit">报名</button>
      </form>

    </div> <!-- /container -->