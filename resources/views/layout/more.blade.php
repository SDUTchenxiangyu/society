@extends('mould.app')
@section('content')
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
@stop
