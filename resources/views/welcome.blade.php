@extends('mould.app')
@section('content')
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>欢迎来到山理建工之家社团网站</h1>
        <p>
          现在正在进行中的比赛有：
          @if(isset($matchopen))
          @foreach($matchopen as $matchopens)
            {{$matchopens}}；
          @endforeach
          @else
          目前暂无比赛
          @endif
        </p>
        <p>
          <a class="btn btn-lg btn-primary" href="{{url('/more')}}" role="button">了解更多</a>
        </p>
      </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
@stop