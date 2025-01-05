$(document).ready(function() {

    $('#zavodnici').DataTable( {
		responsive: false,
		colReorder: true,
		deferRender: true,
		columnDefs: [ 
                    { targets: [0,1,2,3,5,6,7,8,10,12,15], visible: true }, 
                    { targets: '_all', visible: false } 
                ],
		language: {
			url: '../lang/cs.json'
        },
		dom: 'QBfrtip',
		stateSave: false,
        searchBuilder: {
            preDefined: {
                criteria:[
                    {
                        condition: '!=',
                        data: 'Squad',
                        value: ['-9']
                    }
                ],
            }
        },
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
				messageBottom: 'Vytisknuto z administrace závodu Eggenberg CUP [registrace.kps-eggenberg.cz]',
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