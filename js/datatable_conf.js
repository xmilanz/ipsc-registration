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
            'colvis',
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
//                        .prepend(
//                            '<img src="https://www.kps-eggenberg.cz/images/" style="position:absolute; top:0; left:0;" />'
//                        );
 
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'background-image', 'none' );
                }
            }
        ],
         columnDefs: [ {
            targets: -1,
            visible: false
        } ],
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 řádků', '25 řádků', '50 řádků', 'Všechny' ]
        ],
        columnDefs: [ {
            targets: 0,
            visible: true
        } ],

    } );
} )
