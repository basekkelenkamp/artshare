@extends('layouts.layouts')

@section('content')

    <h2>Upload</h2>

    <div class="container">
        <form method="post" enctype="multipart/form-data" action="{{route('store')}}">
            @csrf

            <div class="form-group">
                <label for="image">Choose Image:</label>
                <input id="image" type="file" name="image">
            </div>

            <br>

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name"/>
                @if($errors->has('name'))
                    <span class="alert-danger form-check-inline">{{$errors->first('name')}}</span>
                    @endif
            </div>

            <br>

            <div class="checkboxcheck">
                <label for="tags" class="col-md-4 custom-control-label">Select tags:</label>
                <div class="col-md-6">

                    <legend>Which tags fit your art piece? (select up to three)</legend>
                    @foreach($tags as $tag)
                    <input type="checkbox" name="tags" value="{{ $tag['id'] }}">{{ $tag['name'] }}<br>
                     @endforeach


                @if($errors->has('tags'))
                    <span class="alert-danger form-check-inline">{{$errors->first('tags')}}</span>
                @endif
                </div>

                <br>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" class="form-control" id="description" name="description"/>
                    @if($errors->has('description'))
                        <span class="alert-danger form-check-inline">{{$errors->first('description')}}</span>
                    @endif
                </div>

                <br>

                <input type="hidden" id="state" name="state" value="new">
                <input type="submit" value="Post now" />
            </div>

        </form>
    </div>
@endsection
