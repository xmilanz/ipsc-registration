$(document).ready(function() {

    $('#zavodnici').DataTable( {
		responsive: true,
		colReorder: true,

	language: {
		url: './lang/cs.json'
        },

//	dom: 'QBfrtip', - Q - filtry
	dom: 'Bfrtip',

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
			extend: 'pdfHtml5',
//			orientation: 'landscape',
			pageSize: 'A4'
		},
		{
			extend: 'excelHtml5',
		},
		{
			extend: 'csvHtml5',
		},
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                },
			autoPrint: false,
			messageBottom: 'Vytisknuto z registrace závodu Eggenberg CUP [registrace.kps-eggenberg.cz]',
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
            [ 10, 20, 50, -1 ],
            [ '10 řádků', '20 řádků', '50 řádků', 'Všechny' ]
        ],
    } );
} )
