@extends('Template.front')

@section('head')
	@include('Utilities.topbar')
@endsection

@section('body')
	<!-- SIDEBAR -->
	@include('Utilities.summary_sidebar')
	<!-- LOGIN FIELD -->
	@include('Field.summary')
@endsection

@section('script')
@endsection

@section('style')

@endsection