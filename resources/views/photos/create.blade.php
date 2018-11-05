@extends('layouts.app')

@section('content')
<h3>Upload photo</h3>
{!!Form::open(['action' => 'PhotosController@store','method'=>'post','enctype'=>'multipart/form-data'])!!}
{{Form::text('title','',['placeholder'=>'Photo title'])}}
{{Form::text('description','',['placeholder'=>'Photo description'])}}
{{Form::hidden('album_id',$album_id)}}
{{Form::file('photo')}}
{{Form::submit('submit')}}

{!!Form::close()!!}
@endsection