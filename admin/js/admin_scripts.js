//EXPORT TO PRAKTISCORE
function startExport() {
  fetch('exports.php')
    .then(response => response.blob())
    .then(blob => {
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = "praktiscore_shooters.csv";
      document.body.appendChild(a);
      a.click();
      a.remove();
    });
}

// DROPDOWN
  const dropdownButton1 = document.getElementById('dropdownButton1');
  const dropdownMenu1 = document.getElementById('customDropdown1');
  const dropdownContainer1 = document.getElementById('dropdownContainer1');


  // Zobrazit dropdown pøi najetí myši
  dropdownContainer1.addEventListener('mouseenter', function() {
    dropdownMenu1.classList.add('show');
  });

  // Skrýt dropdown pøi opuštìní myši
  dropdownContainer1.addEventListener('mouseleave', function() {
    dropdownMenu1.classList.remove('show');
  });

  const dropdownButton2 = document.getElementById('dropdownButton2');
  const dropdownMenu2 = document.getElementById('customDropdown2');
  const dropdownContainer2 = document.getElementById('dropdownContainer2');


  // Zobrazit dropdown pøi najetí myši
  dropdownContainer2.addEventListener('mouseenter', function() {
    dropdownMenu2.classList.add('show');
  });

  // Skrýt dropdown pøi opuštìní myši
  dropdownContainer2.addEventListener('mouseleave', function() {
    dropdownMenu2.classList.remove('show');
  });


// DATA TABLE
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();
});

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
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
