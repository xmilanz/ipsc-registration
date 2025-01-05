// Disable form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();


// zobrazit toast
$(document).ready(function(){
  // Přidáme click handler pro všechny elementy, jejichž ID začíná na 'pravidla_registrace'
  $("[id^='pravidla_registrace']").click(function(){
    $('.toast').toast({autohide: false});
    $('.toast').toast('show');
  });
});


function avoidspace(event) {
    var k = event ? event.which : window.event.keyCode;
    if (k == 32) return false;
}

function replaceChars() {
    // IDs aliasů a emailů
    var aliasIDs = [
        "alias-2", 
		"alias101", "alias102", "alias103", "alias104",
        "alias105", "alias106", "alias107", "alias108",

		"alias201", "alias202", "alias203", "alias204", 
        "alias205", "alias206", "alias207", "alias208"
    ];

    var emailIDs = [
        "email-2", 
		"email101", "email102", "email103", "email104", 
        "email105", "email106", "email107", "email108", 

		"email201", "email202", "email203", "email204", 
		"email205", "email206", "email207", "email208"
    ];

    // Zpracování aliasů
    aliasIDs.forEach(function(id) {
        var input = document.getElementById(id).value;
        var output = input.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9]/g, "");
        document.getElementById(id).value = output;
    });

    // Zpracování emailů
    emailIDs.forEach(function(id) {
        var input = document.getElementById(id).value;
        var output = input.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9@\.]/g, "");
        document.getElementById(id).value = output;
    });
}

