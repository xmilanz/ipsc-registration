$(document).ready(function() {

 $('#zavodnici').DataTable( {
  responsive: true,
  colReorder: true,
  deferRender: true,
  stateSave: false,
  columnDefs: [
        { targets: [0,1,2,3,5,6,7,8,15,16,17,18], visible: true }, // placení předem
//        { targets: [0,1,2,3,6,7,8,9,13,16,17], visible: true }, // placení na místě
       { targets: '_all', visible: false } 
  ],
  language: {
  	url: '../lang/cs.json'
        },
        lengthMenu: [
            [ -1, 10, 25, 50],
            [ 'Všechny', '10 řádků', '25 řádků', '50 řádků' ]
        ],
  layout: {
        topStart: {
		searchBuilder: {
			preDefined: {
				criteria:[
					{
						condition: '',
						data: '',
						value: ['']
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
} );