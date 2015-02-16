@extends('Template.front')

@section('head')
	@include('Utilities.topbar')
@endsection

@section('body')
	<!-- SIDEBAR -->
	@include('Utilities.return_sidebar')
	<!-- ASSOCIATED  FIELD -->
	@include('Field.associations')

@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready( function() {

	

	$.getJSON("{{ URL::to('/') }}/fetch/associations",function(data) {
		$('#associate').dataTable({
			"aaData": data,
			"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
			"aaSorting": [[ 3, 'desc' ]],
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
				{"sTitle": "Category", "mDataProp": "category"},
				{"sTitle": "Device", "sWidth": "267px", "mDataProp": "name"},
				{"sTitle": "Owners", "mDataProp": "status"},
				{"sTitle": "Recent Updates", "mDataProp": "updated_at"}

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
				//CATEGORY NAME
				{
					"aTargets": [ 1 ], // Column to target
					"mRender": function ( data, type, full ) {
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return '<a href="{{ URL::to('/') }}/category/' + full["category_id"] + '/profile" class="size-14 dtem">' + full["category"] + '</label>';
					}
				},
				//DEVICE NAME
				{
					"aTargets": [ 2 ], // Column to target
					"mRender": function ( data, type, full ) {
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return '<a href="{{ URL::to('/') }}/device/' + full["id"] + '/profile" class="size-14 dtem">' + full["name"] + '</label>';
					}
				},
				//AVAILABILITY
				{
					"aTargets": [ 3 ], // Column to target
					"mRender": function ( data, type, full ) {
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return '<a href="{{ URL::to("/") }}/location/' + full["location_id"] + '/profile" class="text-center radius size-14 lrv-link"> ' + full["location"] + '</a>';
					}
				},
				//UPDATED AT
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
	$('div.dataTables_filter input').attr('placeholder', 'Category / Date Updated...');
	});
});
</script>
@endsection

@section('style')
@endsection