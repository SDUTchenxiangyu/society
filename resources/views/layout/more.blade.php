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

    <title>网站会员登陆</title>
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
        <table class="table table-bordered">
            <!-- On cells (`td` or `th`) -->
            <tr>
                <td class="active">姓名</td>
                <td class="success">已报名比赛</td>
                <td class="warning">比赛时间</td>
                <td class="danger">比赛地点</td>
                <td class="info">团队/个人</td>
            </tr>
            @if(isset($users))
                @foreach ($users as $user)
                <tr>
                    <td class="active">{{Session::get('name')}}</td>
                    <td class="success">{{$user->name}}</td>
                    <td class="warning">{{$user->time}}</td>
                    <td class="danger">{{$user->place}}</td>
                    <td class="info">{{$user->peoplenum}}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td class="active">您未报名比赛</td>
                    <td class="success">您未报名比赛</td>
                    <td class="warning">您未报名比赛</td>
                    <td class="danger">您未报名比赛</td>
                    <td class="info">您未报名比赛</td>
                </tr>
            @endif
        </table>
    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
    
    <script>
        $(
            function () {
                $('#myAlert').click(
                    function(){
                    $("#alertjgzj").alert();
                    }
                )
        });
    </script>
  </body>
</html>
