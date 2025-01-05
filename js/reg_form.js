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


function avoidspace(event) {
    var k = event ? event.which : window.event.keyCode;
    if (k == 32) return false;
}

function replaceChars(index) {
	var inputAlias = document.getElementById(`Alias${index}`).value;
	var inputEmail = document.getElementById(`Email${index}`).value;
	
	var outputAlias = inputAlias.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9]/g, "");
	var outputEmail = inputEmail.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9@\.]/g, "");

	document.getElementById(`Alias${index}`).value = outputAlias;
	document.getElementById(`Email${index}`).value = outputEmail;
}

function toggleDivizeMain(index) {
    var divize = document.getElementById(`Divize${index}`);
    var divizeDalsi = document.getElementById(`Divize_dalsi${index}`);

    if (divize && divizeDalsi) { // Kontrola, zda oba prvky existují
        if (divize.value) {
            divizeDalsi.disabled = true;
        } else {
            divizeDalsi.disabled = false;
        }
    }
}

function toggleDivize(index) {
    var divize = document.getElementById(`Divize${index}`);
    var divizeDalsi = document.getElementById(`Divize_dalsi${index}`);

    if (divize && divizeDalsi) { // Kontrola, zda oba prvky existují
        if (divizeDalsi.value) {
            divize.disabled = true;
        } else {
            divize.disabled = false;
        }
    }
}
