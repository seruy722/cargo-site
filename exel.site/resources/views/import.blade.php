@extends('layouts.app')

@section('content')
<form action="{{route('importfile')}}" enctype="multipart/form-data" method="POST">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="file" value="Choose file" name="exel">
        <input type="submit" value="Upload">
    </form>
@endsection