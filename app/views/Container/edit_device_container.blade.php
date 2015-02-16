@extends('Template.front')

@section('head')
	@include('Utilities.topbar')
@endsection

@section('body')
	<!-- SIDEBAR -->
	@include('Utilities.category_sidebar')
	<!-- EDIT FIELD -->
	@include('Field.edit')
@endsection

@section('scripts')
@endsection

@section('style')
@endsection