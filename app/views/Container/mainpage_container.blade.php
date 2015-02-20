@extends('Template.front')

@section('head')
@include('Utilities.topbar')
@endsection

@section('body')
	<!-- SIDEBAR UTILITY -->
	@include('Utilities.sidebar')
	<!-- MAINPAGE FIELD -->
	@include('Field.mainpage')
@endsection

@section('scripts')
<script type="text/javascript">

$(document).ready( function() {

	$.getJSON("getCategory", function(data) {
		console.log(data);
		$('#example1').dataTable({
			"aaData": data,
			"aaSorting": [[ 6, 'desc' ]],
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
				{"sTitle": "Category", "sWidth": "70px", "mDataProp": "name"},
				{"sTitle": "Total Device", "sWidth": "105px", "mDataProp": "totalDevice"},
				{"sTitle": "Checked Out", "sWidth": "85px", "mDataProp": "checkedOut"},
				{"sTitle": "Defective/Retired", "sWidth": "70px", "mDataProp": "disposedDevices"},
				{"sTitle": "Available Devices", "mDataProp": "totalAvailable"},
				{"sTitle": "Recent Update", "mDataProp": "updated_at"}

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
				//APPLICANTS FULLNAME
				{
					"aTargets": [ 1 ], // Column to target
					"mRender": function ( data, type, full ) {
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return '<a href="{{ URL::to("/") }}/category/' + full["id"] + '/profile" class="size-14 text-left lrv-link">' + full["name"] + '</a>';
					}
				},

				{
					"aTargets": [ 2 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title
					return '<label class="text-center size-14"> ' + full["totalDevice"] + ' </label>';
					}
				},

				{
					"aTargets": [ 3 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title
					return '<a href="{{ URL::to("/") }}/category/' + full["id"] + '/checkedout" class="lrv-link text-center size-14"> ' + full["checkedOut"] + ' </a>';
					}
				},

				{
					"aTargets": [ 4 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title
					return '<a href="{{ URL::to("/") }}/category/' + full["id"] + '/disposed" class="lrv-link text-center size-14"> ' + full["disposedDevices"] + ' </a>';
					}
				},

				{
					"aTargets": [ 5 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title
					return '<a href="{{ URL::to("/") }}/category/' + full["id"] + '/available" class="lrv-link text-center size-14"> ' + full["totalAvailable"] + ' </a>';
					}
				},


				{
					"aTargets": [ 6 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title
					return '<label class="text-center size-14">' + full["updated_at"] + '</label>';
					}
				},
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
</script>
@endsection