@extends('layouts.layouts')

@section('content')

    <h2>{{$artItem['name']}}</h2>
    <!-- delete & hide button.-->
    @if(\Illuminate\Support\Facades\Auth::id() == $artItem['user_id'] || $admin = 1)
        <form action="{{route('art.hide',$artItem['id'])}}" method="POST">
            @csrf

            <input type="hidden" name="updatehidden" id="updatehidden" value="@if($artItem->hidden == false) 1 @else 0 @endif">
            <input type="hidden" id="id" name="id" value="{{$artItem['id']}}">
            <input type="submit" value="@if($artItem->hidden == false) hide @else unhide @endif" style="background-color: #2d3748"/>
        </form>
        <button onclick="window.location.href='{{route('art.delete',$artItem['id'])}}'" style="background-color: #761b18">delete</button>
    @endif

    <br>
    <br>
    <h2>Edit page</h2>

    <div class="container">

            <img src="{{ asset('storage/'.$artItem->image)}}" alt="" height="250px">
            <br>

        <form method="POST" action="{{route('store')}}">
            @csrf

            <div class="form-group">
                <label for="name">Update name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{$artItem['name']}}"/>
                @if($errors->has('name'))
                    <span class="alert-danger form-check-inline">{{$errors->first('name')}}</span>
                @endif
            </div>

            <br>

            <div class="form-group">
                <label for="description">Update description:</label>
                <input type="text" class="form-control" id="description" name="description" value="{{$artItem['description']}}"/>
                @if($errors->has('description'))
                    <span class="alert-danger form-check-inline">{{$errors->first('description')}}</span>
                @endif
            </div>

            <br>

            <input type="hidden" id="state" name="state" value="update">
            <input type="hidden" id="id" name="id" value="{{$artItem['id']}}">
            <input type="submit" value="Update now" />


        </form>

    </div>


@endsection
