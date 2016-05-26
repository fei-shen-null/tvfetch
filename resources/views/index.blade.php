<!DOCTYPE html>
<html lang="en">
<head>
    <title>美剧订阅 | 美剧下载 | US TV Series Subscribe Download</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-2.2.3.min.js"
            integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
    <script defer src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="{{elixir('css/app.css')}}">
    <script defer src="{{elixir('js/app.js')}}"></script>
</head>
<?php  $WEEK = [
        1 => 'Mon',
        2 => 'Tue',
        3 => 'Wed',
        4 => 'Thu',
        5 => 'Fri',
        6 => 'Sat',
        7 => 'Sun'
]
?>
<header class="container-fluid">
    <div class="jumbotron">
        <h2>美剧订阅 US Series
            <small>Subscribe With Email</small>
        </h2>
        <p>New Episodes Everyday</p>
        <p>Subscribe to fnd out more</p>
    </div>
</header>
<body>
@include('google.analyticstracking')
<nav class="navbar navbar-inverse" id="weekScrollspy">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#weekNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">TV Series</a>
    </div>
    <div class="collapse navbar-collapse" id="weekNavbar">
        <ul class="nav navbar-nav">
            @foreach($WEEK as $day)
                <li><a href="#tvList{{$day}}">{{$day}}</a></li>
            @endforeach
        </ul>
        <ul id="logoutBtn" class="nav navbar-nav navbar-right">
            <li><a href="" onclick="location.href='logout'" target="_self" class="glyphicon glyphicon-off"></a></li>
        </ul>
    </div>
</nav>
<div class="container-fluid">
    @foreach($WEEK as $key=>$day)
        <div class="tvList center-block" id="tvList{{$day}}">
            @if(isset($tvList[$key]))
                <div class="panel-group" id="accordion{{$day}}">
                    @foreach($tvList[$key] as $tv)
                        <div class="panel panel-{{$subList->contains($tv->id)? 'success':'default'}}">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion{{$day}}"
                                       href="#collapse{{$tv->id}}">{{$tv->name_cn.' | '.$tv->name_en}}
                                    </a>
                                    @if($subList->contains($tv->id))
                                        <a class="pull-right" data-toggle="tooltip" data-placement="auto right"
                                           title="Unsubscribe">
                                    <span id="sub{{$tv->id}}" onclick="unSubTv({{$tv->id}})"
                                          class="glyphicon glyphicon-check"></span>
                                        </a>
                                    @else
                                        <a class='pull-right' data-toggle="tooltip" data-placement="auto right"
                                           title="Subscribe">
                                        <span id="sub{{$tv->id}}" onclick="subTv({{$tv->id}})"
                                              class="glyphicon glyphicon-unchecked"></span>
                                        </a>
                                    @endif
                                </h4>
                            </div>
                            <div id="collapse{{$tv['id']}}" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul class="list-group list-inline">
                                        <li class="list-group-item">Genre: {{$tv->genre}}</li>
                                        <li class="list-group-item">Channel: {{$tv->channel}}</li>
                                        <li class="list-group-item">Status: {{$tv->status}}</li>
                                        <li class="pull-right">
                                            <span data-toggle="modal" data-target="#tvSource">
                                                <a onclick="showTvDetailModail({{$tv->id}})"
                                                   data-toggle="tooltip" data-placement="auto right" title="Details">
                                                    <span class="glyphicon glyphicon-link"></span>
                                                </a>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>
@if(!Session::has('email'))
    @include('modal.login')
@endif
@include('modal.tvDetail')
</body>
</html>
