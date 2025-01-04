$(document).ready(function() {

    $('#zavodnici').DataTable( {
		responsive: true,
		colReorder: true,

	language: {
			url: './lang/cs.json'
        },

		dom: 'QBfrtip',

       buttons: [
			{
				extend: 'pageLength'
			},
//            'colvis',
           {
                extend: 'spacer',
                text: '     '
            },
			{
				extend: 'pdf',
				exportOptions: {
                    columns: ':visible'
                }
			},
			{
				extend: 'excel',
				exportOptions: {
                    columns: ':visible'
                }
			},
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                },
		autoPrint: false,
		customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'background-image', 'none' );
                }
            }
        ],
        lengthMenu: [
            [ -1, 15, 50 ],
            [ 'Všechny', '15 řádků', '50 řádků' ]
        ],
    } );
} )
