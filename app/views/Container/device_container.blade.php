@extends('Template.front')

@section('head')
@include('Utilities.topbar')
@endsection

@section('body')
	<!-- SIDEBAR UTILITY -->
	@include('Utilities.category_sidebar')
	<!-- MAINPAGE FIELD -->
	@include('Field.device')
@endsection

@section('scripts')
<script type="text/javascript">

$('#dp1').fdatepicker({
	format: 'mm/dd/yyyy',
});

$('#dp2').fdatepicker({
	format: 'mm/dd/yyyy',
});



	$(document).ready(function() {
		var max_fields      = 10; //maximum input boxes allowed
		var wrapper         = $(".input_fields_wrap"); //Fields wrapper
		var add_button      = $(".add_field_button"); //Add button ID

		var x = 1; //initlal text box count
		$(add_button).click( function ( e ){ //on add input button click
			e.preventDefault();
			if(x < max_fields){ //max input box allowed
				x++; //text box increment
				$(wrapper).append('<div class="row"><div class="large-12 columns large-centered"><div class="row"><div class="large-10 columns"><input type="text" name="mytext[]" placeholder="Enter device data-field"/></div><a href="#" id="Font" class="tiny remove_field radius"><i class="fi-x size-16" style=" line-height: 2.3rem; "></a></div></div></div>'); //add input box
			}
		});

		$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
			e.preventDefault(); 
			$(this).parent('div').remove();
			x--;
		});
	});
$(document).ready( function() {
	$.getJSON("{{ URL::to('/') }}/getDevice/{{ $category->id }}",function(data) {
		console.log(data);
		$('#example1').dataTable({
			"aaData": data,
			"oLanguage": {
				"sLengthMenu": "No. of Items to display _MENU_",
				"oPaginate": {
				"sFirst": "First ", // This is the link to the first 
				"sPrevious": "&#8592; Previous", // This is the link to the previous 
				"sNext": "Next &#8594;", // This is the link to the next 
				"sLast": "Last " // This is the link to the last 
				}
			},
			//DISPLAYS THE VALUE
			//sTITLE - HEADER
			//MDATAPROP - TBODY
			"aoColumns": 
			[
				{"sTitle": "#", "mDataProp": "id", "sClass": "size-14"},
				{"sTitle": "Description", "sWidth": "150px", "mDataProp": "name"},
				{"sTitle": "Tag", "sWidth": "150px", "mDataProp": "tag"},
				{"sTitle": "Status", "sWidth": "130px","mDataProp": "status"},
				{"sTitle": "Owner", "sWidth": "150px","mDataProp": "location_name"},

			],
			"aoColumnDefs": 
			[
				//FORMAT THE VALUES THAT IS DISPLAYED ON mDataProp
				//ID
				{ "bSortable": false, "aTargets": [ 0 ] },
				{
					"aTargets": [ 0 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title

					return '<label class="text-center size-14">' + data + '</label>';
					}
				},
				//DESCRIPTION
				{
					"aTargets": [ 1 ], // Column to target
					"mRender": function ( data, type, full ) {
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return '<label class="size-14 dtem">' + full["name"] + '</label>';
					}
				},
				//DESCRIPTION
				{
					"aTargets": [ 2 ], // Column to target
					"mRender": function ( data, type, full ) {
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return '<label class="size-14 dtem">' + full["tag"] + '</label>';
					}
				},

				{
					"aTargets": [ 3 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						if ( full["status"] == "Retired"  ) {
							return '<label class="text-center size-14 alert-box radius alert alert-custom">' + full["status"] + '</label>';
						} else if ( full["status"] == "Normal"  ) {
							return '<label class="text-center size-14 alert-box radius success alert-custom">ACTIVE</label>';
						} else if ( full["status"] == "ACTIVE") {
							return '<label class="text-center size-14 alert-box radius success alert-custom">ACTIVE</label>';
						} else if ( full["status"] == "Defective" ) {
							return '<label class="text-center size-14 alert-box radius alert alert-custom">' + full["status"] + '</label>';
						} else if ( full["status"] == "INACTIVE" ) {
							return '<label class="text-center size-14 alert-box radius alert alert-custom">' + full["status"] + '</label>';
						} else if ( full["status"] == "Not Specified" ) {
							return '<label class="text-center size-14 alert-box radius warning alert-custom">' + full["status"] + '</label>';
						}
					}
				},
				{
					"aTargets": [ 4 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title
					if ( full["location_id"] != 0 ) {
						if ( full["location_name"] != "" ) {
							return '<label class="text-center size-14 alert-box radius warning alert-custom"> ' + full["location_name"] + '</label>';
						} else {
							return '<label class="text-center size-14 alert-box radius warning alert-custom"> ' + full["owner_name"] + '</label>';
						}
					} else if ( full["status"] == "Retired" || full["status"] == "Defective" || full["status"] == "INACTIVE" ) {
						return '<label class="text-center size-14 alert-box radius alert alert-custom">Not Available</label>';
					} else if ( full["status"] == "Normal" || full["status"] == "ACTIVE") {
						return '<label class="text-center size-14 alert-box radius success alert-custom">Available</label>';
					} else if ( full["status"] == "Not Specified" ) {
						return '<label class="text-center size-14 alert-box radius warning alert-custom">N/A</label>';
					}
				}},
			],

			//Assign ID
			"fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			//var id = aData[0];
				var id = aData.id;
				$(nRow).attr("data-pass", id);
				return nRow;
			},

			"fnDrawCallback": function( oSettings ) {
				$('#example1 tbody tr').click( function() {
					var id = $(this).attr("data-pass");
					document.location.href = "{{ URL::to('/') }}/device/" + id + "/profile";
				});

				$('#example1 tbody tr').hover(function() {
					$(this).css('cursor', 'pointer');
				}, function() {
					$(this).css('cursor', 'auto');
				});
				/* Need to redo the counters if filtered or sorted */
				if ( oSettings.bSorted || oSettings.bFiltered )
				{
					for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
					{
						$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( "<label>" + (i+1) + "</label>" );
					}
				}
			}
		});
	$('div.dataTables_filter input').attr('placeholder', 'Category / Date Created...');
	});
});
</script>
@endsection