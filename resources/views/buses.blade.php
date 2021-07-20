<h1> 車車動態表</h1>
<table border="1">
    <tr>
 
        <td>車號</td>
        <td>位置</td>
        <td>時間</td>
    </tr>
    @foreach ($bus as $item)
    <tr>
        <td>{{$item['PlateNumb']}}</td>
        <td>{{$item['X']}},{{$item['Y']}}</td>
        <td>{{$item['GPS_Time']}}</td>
    </tr>
    @endforeach
</table>