$(document).ready(function() {

    $('#zavodnici').DataTable( {
		responsive: false,
		colReorder: true,
		deferRender: true,
	language: {
			url: '../lang/cs.json'
        },

		dom: 'QBfrtip',
		stateSave: false,
        buttons: [
			{
				extend: 'pageLength'
			},
			{
            	extend: 'colvis',
                collectionLayout: 'fixed columns',
                collectionTitle: 'Viditelné sloupce'
			},
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
                        .css( 'font-size', '10px' )
                    $(win.document.body).find( 'table' )
                        .addClass( 'print' )
                    $(win.document.body).find( 'td' )
                        .addClass( 'print' );
                    $(win.document.body).find( 'th' )
                        .addClass( 'print' );
                }
            },
           {
                extend: 'spacer',
                text: '     '
            },
        ],
        lengthMenu: [
            [ -1, 10, 25, 50],
            [ 'Všechny', '10 řádků', '25 řádků', '50 řádků' ]
        ],
    } );
} );