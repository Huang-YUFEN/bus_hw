@extends('base')
<link rel='stylesheet' href='https://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css'>
@section('main')
<div class="row">
<div class="col-sm-12">
<h1 class="display-3" style="margin: 20px 0 20px 35%;">車車動態表</h1>    
    
    <div class="col-sm-12">
    @if ($errors->any())
        <div class="alert alert-danger">

        <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
      </ul>
      </div>
      <br />
      @endif

      @if(session()->get('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
      </div>
      @endif
      @if(session()->get('fail'))
      <div class="alert alert-warning">
        {{ session()->get('fail') }}
      </div>
 　　 @endif
    </div>

  <table class="table table-striped" border="1">
    <thead>
        <tr>
          <td><h5>公車車號</h5></td>
          <td><h5>路程(去程:0 回程:1)</h5></td>
          <td><h5>車牌</h5></td>
          <td><h5>時間</h5></td>
          <td><h5>X</h5></td>
          <td><h5>Y</h5></td>

          <td><h5>動作</h5></td>
          <td><a href="{{ url('buses/create') }}" class="btn btn-primary" >查詢</a></td>
        </tr>
    </thead>
    <tbody>
        @foreach($buses as $bus)
        <tr>
            <td>{{$bus->number}}</td>
            <td>{{$bus->road}}</td>
            <td>{{$bus->PlateNumb}}</td>
            <td>{{$bus->GPS_Time}}</td>
            <td>{{$bus->X}}</td>
            <td>{{$bus->Y}}</td>
            <td>
                <a href="{{ route('buses.edit',$bus->id)}}" class="btn btn-primary">更新</a>
            </td>
            <td>
                <form action="{{ route('buses.destroy', $bus->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" onclick="return confirm('Are you sure?')" type="submit">刪除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
</div>
@endsection

