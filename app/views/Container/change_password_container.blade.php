@extends('Template.front')



@section('head')
	@include('Utilities.topbar')
@endsection



@section('body')
	{{ Form::open(array('url'=>'update_password')) }}
	@include('Field.change_password')
	{{ Form::close() }}
@endsection



@section('scripts')
@endsection



@section('styles')
@endsection