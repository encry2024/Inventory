@extends('Template.front')

@section('head')
	@include('Utilities.topbar')
@endsection

@section('body')
	<!-- SIDEBAR -->
	@include('Utilities.return_sidebar')
	<!-- EDIT FIELD -->
	@include('Field.available')

@endsection

@section('scripts')
@endsection

@section('style')
@endsection