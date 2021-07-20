@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-3">更新車車</h1>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br/>
        @endif
        <form method="post" action="{{ route('buses.update', $bus->id) }}">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="number">公車車號</label>
                <input type="text" class="form-control" name="number" value={{ $bus->number }}>
            </div>
            <div class="form-group">
                <label for="road">路程(去程:0 回程:1)</label>
                <input type="text" class="form-control" name="road" value={{ $bus->road }} />
            </div>
            <button type="submit" class="btn btn-primary">更新資料</button>
        </form>
    </div>
</div>
@endsection