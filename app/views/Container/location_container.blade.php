@extends('Template.front')

@section('head')
	@include('Utilities.topbar')
@endsection

@section('body')
	<!-- SIDEBAR -->
	@include('Utilities.location_sidebar')
	<!-- EDIT FIELD -->
	@include('Field.location')
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready( function() {
	$.getJSON("retrieve_location", function(data) {
		$('#location').dataTable({
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
				{"sTitle": "Lastname", "sWidth": "200px", "mDataProp": "firstname"},
				{"sTitle": "Firstname", "sWidth": "200px", "mDataProp": "lastname"},
				{"sTitle": "Location", "sWidth": "200px", "mDataProp": "name"},
				{"sTitle": "Date Modified", "mDataProp": "updated_at"}
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
				//OWNERS LASTNAME
				{
					"aTargets": [ 1 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title

					return '<label class="text-center size-14">' + full["lastname"] + '</label>';
					}
				},
				//OWNER'S FIRSTNAME
				{
					"aTargets": [ 2 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title

					return '<label class="text-center size-14">' + full["firstname"] + '</label>';
					}
				},

				//Owner's Location
				{
					"aTargets": [ 3 ], // Column to target
					"mRender": function ( data, type, full ) {
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return '<label class="size-14 dtem">' + full["name"] + '</label>';
					}
				},

				{
					"aTargets": [ 4 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title
					return '<label class="text-center size-14">' + full["updated_at"] + '</label>';
					}
				},
			],

			//Assign ID
			"fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			//var id = aData[0];
				var id = aData.id;
				$(nRow).attr("data-pass", id);
				return nRow;
			},

			"fnDrawCallback": function( oSettings ) {
				$('#location tbody tr').click( function() {
					var id = $(this).attr("data-pass");
					document.location.href = "{{ URL::to('/') }}/location/" + id + "/profile";
				});

				$('#location tbody tr').hover(function() {
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
		$('div.dataTables_filter input').attr('placeholder', 'Location...');
	});
});
</script>
@endsection

@section('style')
@endsection