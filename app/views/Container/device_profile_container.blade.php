@extends('Template.front')

@section('head')
	@include('Utilities.topbar')
@endsection

@section('body')
	<!-- SIDEBAR -->
	@include('Utilities.edit_device_sidebar')
	<!-- EDIT FIELD -->
	@include('Field.device_profile')

@endsection

@section('scripts')
<script type="text/javascript">

$('#dp1').fdatepicker({
	format: 'mm/dd/yyyy',
});

$('#dp2').fdatepicker({
	format: 'mm/dd/yyyy',
});

$(document).ready( function() {
	
	$.getJSON("{{ URL::to('/') }}/fetch/{id}/location", function(data) {
		var datalist = [];

		$.each(data, function(key, val) {
			datalist.push({value: val.id, text: val.lastname + " " + val.firstname + " - Location - " + val.name});
		});

		console.log(datalist);
		$('#demo').multilist({
			single: true,
			labelText: 'Select One Item',
			datalist: datalist,
			enableSearch: true,
		});
	});
	$.getJSON("{{ URL::to('/') }}/getDeviceLog/{{ $device->id }}",function(data) {
		$('#device_log').dataTable({
			"aaData": data,
			"aaSorting": [[ 4, 'desc' ]],
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
				{"sTitle": "Device", "sWidth": "267px", "mDataProp": "loc_name"},
				{"sTitle": "Event", "mDataProp": "events"},
				{"sTitle": "Owner", "mDataProp": "dev_name"},
				{"sTitle": "Date Log", "mDataProp": "updated_at"}

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
				//DEVICE NAME
				{
					"aTargets": [ 1 ], // Column to target
					"mRender": function ( data, type, full ) {
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return '<a href="{{ URL::to("/") }}/device/' + full["device_id"] + '/profile" class="size-14 lrv-link dtem">' + full["dev_name"] + '</a>';
					}
				},
				
				{
					"aTargets": [ 2 ], // Column to target
					"mRender": function ( data, type, full ) {
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return '<label class="text-center size-14 radius">' + full["events"] + '</label>';
					}
				},
				{
					"aTargets": [ 3 ], // Column to target
					"mRender": function ( data, type, full ) {
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						if ( full["loc_name"] != "" ) {
							return '<a href="{{ URL::to("/") }}/location/' + full["location_id"] + '/profile" class="size-14 dtem">' + full["loc_name"] + '</label>';
						} else {
							return '<a href="{{ URL::to("/") }}/location/' + full["location_id"] + '/profile" class="size-14 dtem">' + full["owner_name"] + '</label>';

						}
					}
				},
				//dateofapplication
				{
					"aTargets": [ 4 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title
					return '<label class="text-center size-14">' + full["updated_at"] + '</label>';
					}
				}
			],

			"fnDrawCallback": function( oSettings ) {
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

	function assignDeviceProperty(id, name) {
		document.getElementById("devLabel").innerHTML = name;
		document.getElementById("id_textbox").value = id;
	}

	function dissociateDeviceProperty(id, name, loc_name) {
		document.getElementById("deviLabel").innerHTML = name;
		document.getElementById("id_txtbox").value = id;
		document.getElementById("location_label").innerHTML = loc_name;
	}

	function getDevProperty(id, name) {
		document.getElementById("device_name").innerHTML = name ;
		document.getElementById("device_id").value = id;
	}

	function getValue(id, name) {
		document.getElementById("dev_name").innerHTML = "Change " + name + " Status";
		document.getElementById("dev_id").value = id;
	}
</script>
@endsection

@section('style')
@endsection