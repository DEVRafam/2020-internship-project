@extends('layouts.app')
@section('content')

<div class="container d-flex justify-content-center">
    <div class="row col-6">
            <div class="panel panel-default">
                <div id='addThreadWrapper'>
                    <div class="panel-head">
                        <h1>
                            Create a new thread
                        </h1>
                    </div>
                    <hr>
                    <form action="/threads" method='POST'>
                        @csrf
                        <div class="form-group">
                          <label for="channel_id"><h5>Choose a Channel</h5></label>
                          <select class="form-control" name="channel_id" id="">
                            <option value=''>Choose one</option>
                            @foreach(App\Channel::all() as $item)
                                <option {{old('channel_id')==$item->id ? 'selected' : ''}} value='{{$item->id}}'> {{$item->name}}</option>

                            @endforeach
                          </select>
                          @error('channel_id')
                              <span style='color: #d63031'>{{$message}}</span>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="title"><h5>Title:</h5></label>
                          <input type="text"
                        class="form-control" name="title" id="title" aria-describedby="helpId" value="{{old('title')}}">
                            @error('title')
                                <span style='color: #d63031'>{{$message}}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                          <label for="body"><h5>Body:</h5></label>
                        <textarea class="form-control" name="body" id="body" rows="3">{{old('body')}}</textarea>
                          @error('body')
                              <span style='color: #d63031'>{{$message}}</span>
                          @enderror

                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            
        </div>
    </div>
</div>
@endsection