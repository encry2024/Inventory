@extends('Template.front')

@section('head')
	@include('Utilities.topbar')
@endsection

@section('body')
{{ Form::open(array('url' => 'addcategory')) }}
	<!-- SIDEBAR -->
	@include('Utilities.category_add_sidebar')
	<!-- EDIT FIELD -->
	@include('Field.category_add')
{{ Form::close() }}
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		var max_fields      = 10; //maximum input boxes allowed
		var wrapper         = $(".input_fields_wrap"); //Fields wrapper
		var add_button      = $(".add_field_button"); //Add button ID

		var x = 1; //initlal text box count
		$(add_button).click(function(e){ //on add input button click
			e.preventDefault();
			if(x < max_fields){ //max input box allowed
				x++; //text box increment
				$(wrapper).append('<div class="row"><div class="large-12 columns large-centered"><div class="row"><div class="large-4 columns"><input type="text" style=" margin-top: -0.5rem; margin-left: 15rem; " class="radius" name="mytext[]"/></div><a href="#" id="Font" class="tiny remove_field radius"><i class="fi-x size-16" style="  margin-left: 15rem; "></a></div></div></div>'); //add input box
			}
		});

		$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
			e.preventDefault(); 
			$(this).parent('div').remove();
			x--;
		});
	});

</script>
@endsection

@section('style')
@endsection