@extends('layouts.layouts')

@section('content')

    <h2>Search</h2>

    <form action="{{route('search.submit')}}" method="POST">
        @csrf

        <div class="input-group">
            <input type="text" class="form-control" name="name" placeholder="Search name">
        </div>

        <br>

        <div class="input-group">
            <input type="text" class="form-control" name="description" placeholder="Search description">
        </div>

        <br>

        <button type="submit" class="btn btn-default">Search</button>
    </form>

    @if(@isset($searched))
        @if($searched !== "nothing")
            <h2>Showing {{count($posts)}} results for {{$searched}}.</h2>

            <div class="thumbnails">

                @foreach($posts as $post)

                    <div class="box">

                        <div class="inner">
                            <h3>{{$post['name']}}</h3>
                            <img src="{{ asset('storage/'.$post->image)}}" alt="img" width="200" height="200">
                            <p>{{$post['description']}}</p>
                            <a href="{{route('art.link',$post['id'])}}" class="button fit">Details</a>
                        </div>
                    </div>


                @endforeach
            </div>


        @endif

    @endif
@endsection
