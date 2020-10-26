@extends('layouts.layouts')

@section('content')

    <h2>{{$artItem['name']}}</h2>
    <br>
    <h2>Are you sure you want to delete the post "{{$artItem['name']}}"?</h2>

    <div class="container">

            <img src="{{ asset('storage/'.$artItem->image)}}" alt="" height="250px">
            <br>

        <form method="POST" action="{{route('store')}}">
            @csrf

            <input type="hidden" id="state" name="state" value="delete">
            <input type="hidden" id="id" name="id" value="{{$artItem['id']}}">
            <input type="submit" value="Delete now" style="background-color: #761b18"/>

        </form>

        <form action="{{route('art')}}">
            <input type="submit" value="Cancel">
        </form>

    </div>


@endsection
