<html>
<body>
<table>
    @foreach($newTv as $tv)
        <tr>
            <td>{{$tv['name_cn']}}</td>
            |
            <td></td>{{$tv['name_en']}}
            <td></td>
            <td><a href="http://cn163.net/archives/{{$tv['id']}}">
                    <button>Details</button>
                </a></td>
            <td><a href="{{env('APP_URL').'/subscribe/'.$tv['id']}}">
                    <button>Subscribe</button>
                </a>
            <td></td>
        </tr>
    @endforeach

</table>
</body>
</html>

