@extends('base')

@section('main')
<div class="row">
 <div class="col-sm-8 offset-sm-2">
    <h1 class="display-3">公車查詢</h1>
  <div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('buses.store') }}"  enctype="multipart/form-data" >
          @csrf



          <div class="form-group">
              <label for="name">車號</label>
              <input type="text" class="form-control" name="number"/>
          </div>

          <div class="form-group">
              <label for="input">路程(回程:0 去程:1)</label>
              <input type="text" class="form-control" name="road"/>
          </div>

          <button type="submit" class="btn btn-primary">查詢</button>
      </form>
  </div>
</div>
</div>
@endsection