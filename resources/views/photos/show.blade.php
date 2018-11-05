@extends('layouts.app')

@section('content')
<h3>{{$photo->title}}</h3>

<a href="/albums/{{$photo->album_id}}">Back to gallery</a>
<hr>
<img src="/storage/photos/{{$photo->album_id}}/{{$photo->photo}}" alt="{{$photo->title}}">
<br><br>
{!!Form::open(['action'=>["PhotosController@destroy",$photo->id,'method'=>'post']])!!}
    {{Form::hidden('_method','delete')}}
    {{Form::submit('Delete photo',['class'=>'button alert'])}}
{!!Form::close()!!}
<hr>
<small>Size: {{$photo->size}}</small>
@endsection