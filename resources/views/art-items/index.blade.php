@extends('layouts.layouts')

@section('content')

    <h2>Browse all posts</h2>
    <!-- Boxes -->
    <div class="thumbnails">

        @foreach($artItems as $artItem)

            <div class="box">

                <!-- Edit, delete & hide button if user is owner of the post or is admin.-->
                @if(\Illuminate\Support\Facades\Auth::id() == $artItem['user_id'] || $admin == 1)
                    <button onclick="window.location.href='{{route('art.edit',$artItem['id'])}}'" style="background-color: #2a9055">edit</button>
                    <button onclick="window.location.href='{{route('art.delete',$artItem['id'])}}'" style="background-color: #761b18">delete</button>
                    <form action="{{route('art.hide',$artItem['id'])}}" method="POST">
                        @csrf

                        <input type="hidden" name="updatehidden" id="updatehidden" value="@if($artItem->hidden == false) 1 @else 0 @endif">
                        <input type="hidden" id="id" name="id" value="{{$artItem['id']}}">
                        <input type="submit" value="@if($artItem->hidden == false) hide @else unhide @endif" style="background-color: #2d3748"/>
                    </form>
                @endif

                <div class="inner">
                    <h3>{{$artItem['name']}}</h3>
                    <img src="{{ asset('storage/'.$artItem->image)}}" alt="img" width="200" height="200">
                    <p>{{$artItem['description']}}</p>
                    <a href="{{route('art.link',$artItem['id'])}}" class="button fit">Details</a>
                </div>
            </div>


        @endforeach
    </div>


@endsection
