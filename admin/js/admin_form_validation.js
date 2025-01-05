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

function replaceChars() {
	var input1 = document.getElementById("Alias").value;
	var input2 = document.getElementById("Mail").value;
	
	var output1 = input1.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9]/g, "");
	var output2 = input2.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9@\.]/g, "");

	document.getElementById("Alias").value = output1;
	document.getElementById("Mail").value = output2;
}

function avoidspace(event) {
    var k = event ? event.which : window.event.keyCode;
    if (k == 32) return false;
}
