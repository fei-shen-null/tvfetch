<!DOCTYPE html>
<html lang="en">
<head>
    <title>US TV Series Subscribe | Download</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
            crossorigin="anonymous"></script>
    <script src="/js/app.js"></script>
    <link rel="stylesheet" href="/css/app.css">
</head>
<?php $week = [
        1 => 'Mon',
        2 => 'Tue',
        3 => 'Wed',
        4 => 'Thu',
        5 => 'Fri',
        6 => 'Sat',
        7 => 'Sun'
]
?>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" id="weekScrollspy">
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
            @foreach($week as $day)
                <li><a href="#tvList{{$day}}">{{$day}}</a></li>
            @endforeach
        </ul>
    </div>
</nav>
@foreach($week as $key=>$day)
    <div class="container tvList" id="tvList{{$day}}">
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
                                    <a href="{{url('/unsubscribe/'.$tv->id)}}" class="pull-right" data-toggle="tooltip"
                                       data-placement="auto right" title="Unsubscribe">
                                        <span class="glyphicon glyphicon-check"></span>
                                    </a>
                                @else
                                    <a href="{{url('/subscribe/'.$tv->id)}}" class='pull-right' data-toggle="tooltip"
                                       data-placement="auto right" title="Subscribe">
                                        <span class=" glyphicon glyphicon-unchecked"></span>
                                    </a>
                                @endif
                            </h4>
                        </div>
                        <div id="collapse{{$tv['id']}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                {{$tv->genre}}
                                <span data-toggle="modal" data-target="#tvSource">
                                <a data-href="{{env('TVFETCH_SOURCE').$tv->id}}" class="pull-right"
                                   data-toggle="tooltip" data-placement="auto right" title="Details">
                                    <span onclick="setHref(this)" class="glyphicon glyphicon-link"></span>
                                </a>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endforeach
</body>
</html>
