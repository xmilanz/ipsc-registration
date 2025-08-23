// DROPDOWN
  const dropdownButton1 = document.getElementById('dropdownButton1');
  const dropdownMenu1 = document.getElementById('customDropdown1');
  const dropdownContainer1 = document.getElementById('dropdownContainer1');


  // Zobrazit dropdown pri najeti mysi
  dropdownContainer1.addEventListener('mouseenter', function() {
    dropdownMenu1.classList.add('show');
  });

  // Skryt dropdown pri opusteni mysi
  dropdownContainer1.addEventListener('mouseleave', function() {
    dropdownMenu1.classList.remove('show');
  });

  const dropdownButton2 = document.getElementById('dropdownButton2');
  const dropdownMenu2 = document.getElementById('customDropdown2');
  const dropdownContainer2 = document.getElementById('dropdownContainer2');


  // Zobrazit dropdown pri najeti mysi
  dropdownContainer2.addEventListener('mouseenter', function() {
    dropdownMenu2.classList.add('show');
  });

  // Skryt dropdown pri opusteni mysi
  dropdownContainer2.addEventListener('mouseleave', function() {
    dropdownMenu2.classList.remove('show');
  });


// DATA TABLE
$(document).ready(function(){
  $('[data-bs-toggle="popover"]').popover();
});

$(document).ready(function(){
  $('[data-bs-toggle="tooltip"]').tooltip();   
});

function ToggleFilter() {
  var elements = document.getElementsByClassName("dtsb-searchBuilder");
  
  for (var i = 0; i < elements.length; i++) {
    var x = elements[i];
    if (x.style.display === "block") {
      x.style.display = "none";
    } else {
      x.style.display = "block";
    }
  }
}

// Uploader
$(function () {  
    $(document).on('click', '.btn-add', function (e) {  
        e.preventDefault();  
        var controlForm = $('.controls:first'),  
            currentEntry = $(this).parents('.entry:first'),  
            newEntry = $(currentEntry.clone()).appendTo(controlForm);  
        newEntry.find('input').val('');  
        controlForm.find('.entry:not(:last) .btn-add')  
            .removeClass('btn-add').addClass('btn-remove')  
            .removeClass('btn-success').addClass('btn-danger')  
            .html('<span class="fa fa-trash"> </span>');  
    }).on('click', '.btn-remove', function (e) {  
        $(this).parents('.entry:first').remove();  
        e.preventDefault();  
        return false;  
    });  
});  

// reopen modals
	// divison
    $(document).ready(function(){
        // Check if URL contains the reopen_modal parameter
        if (window.location.search.indexOf('divisions') > -1) {
            $('#manage_divisions').modal('show');
        }

        $('#manage_divisions').on('hidden.bs.modal', function (e) {
            if (shouldReopenModal()) {
                $('#manage_divisions').modal('show');
            }
        });

        function shouldReopenModal() {
            return false; // This condition can remain as false for now
        }
    });
    $(document).ready(function() {
        if (window.location.search.indexOf('divisions') > -1) {
            // Remove the parameter from URL
            window.history.replaceState(null, null, window.location.pathname);
        }
    });


	// categories
    $(document).ready(function(){
        // Check if URL contains the reopen_modal parameter
        if (window.location.search.indexOf('categories') > -1) {
            $('#manage_categories').modal('show');
        }

        $('#manage_categorys').on('hidden.bs.modal', function (e) {
            if (shouldReopenModal()) {
                $('#manage_categories').modal('show');
            }
        });

        function shouldReopenModal() {
            return false; // This condition can remain as false for now
        }
    });
    $(document).ready(function() {
        if (window.location.search.indexOf('categories') > -1) {
            // Remove the parameter from URL
            window.history.replaceState(null, null, window.location.pathname);
        }
    });


	// squads
    $(document).ready(function(){
        // Check if URL contains the reopen_modal parameter
        if (window.location.search.indexOf('squads') > -1) {
            $('#manage_squads').modal('show');
        }

        $('#manage_squads').on('hidden.bs.modal', function (e) {
            if (shouldReopenModal()) {
                $('#manage_squads').modal('show');
            }
        });

        function shouldReopenModal() {
            return false; // This condition can remain as false for now
        }
    });
    $(document).ready(function() {
        if (window.location.search.indexOf('squads') > -1) {
            // Remove the parameter from URL
            window.history.replaceState(null, null, window.location.pathname);
        }
    });

function avoidspace(event) {
    var k = event ? event.which : window.event.keyCode;
    if (k == 32) return false;
}
