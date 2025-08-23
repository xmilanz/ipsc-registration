$(document).ready(function() {

    $('#zavodnici').DataTable( {
		responsive: true,
//		colReorder: true,

	language: {
		url: './lang/cs.json'
        },

layout: {
        topStart: {
	       buttons: [
			{
				extend: 'pageLength'
			},
	           {
	                extend: 'spacer',
	                text: '     '
	            },
//			{
//				extend: 'pdfHtml5',
//				pageSize: 'A4'
//			},
//			{
//				extend: 'excelHtml5',
//			},
//			{
//				extend: 'csvHtml5',
//			},
	            {
	                extend: 'print',
	                exportOptions: {
	                    columns: ':visible'
	                },
				autoPrint: false,
				messageBottom: 'Vytisknuto z registrace závodu SSAŠ střelnice Prachtice',
				customize: function ( win ) {
					$(win.document.body)
						.css( 'font-size', '10pt' )
					$(win.document.body).find( 'table' )
						.addClass( 'compact' )
						.css( 'background-image', 'none' );
						}
	            }
	        ],
        },
        topEnd: {
            search: {
                placeholder: 'Hledat'
            }
        },
        bottomEnd: {
            paging: {
                numbers: 3
            }
        }
    }
    } );
} )
