@extends('layouts.layouts')

@section('content')

    <h2>{{$artItem['name']}}</h2>
    <h3>By {{\App\Models\User::find($artItem['user_id'])->name}}</h3>
    <div class="container">

            <!-- Edit & delete button if user is owner of the post or is admin.-->
            @if(\Illuminate\Support\Facades\Auth::id() == $artItem['user_id'] ||$admin == 1)
                <button onclick="window.location.href='{{route('art.edit',$artItem['id'])}}'" style="background-color: #2a9055">edit</button>
                <button onclick="window.location.href='{{route('art.delete',$artItem['id'])}}'" style="background-color: #761b18">delete</button>
            <br>
            <br>
        @endif
            <img src="{{ asset('storage/'.$artItem->image)}}" alt="" width="800">
            <br>
            <p>{{$artItem['description']}}</p>
            <br>

    </div>


    <h2>Comments</h2>
    <div class="container">
        <form method="post" action="{{route('store')}}">

            @csrf

                <div class="form-group">
                    <label for="description">Write a comment:</label>
                    <input type="text" class="form-control" id="description" name="description"/>
                    @if($errors->has('description'))
                        <span class="alert-danger form-check-inline">{{$errors->first('description')}}</span>
                    @endif
                </div>

                <br>

                <input type="hidden" id="state" name="state" value="comment">
                <input type="hidden" id="id" name="id" value="{{$artItem['id']}}">
                <input type="submit" value="Post comment" />

        </form>

        @foreach($comments as $comment)

            <div class="box" style="text-align: left">
                <h3>{{\App\Models\User::find($comment['user_id'])->name}}</h3>
                <h2 style="font-style: italic">{{$comment['description']}}</h2>
                <h4>{{$comment['created_at']}}</h4>
            </div>

            @endforeach
    </div>

@endsection
