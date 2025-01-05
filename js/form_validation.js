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
	var input0 = document.getElementById("Alias").value;
	var input1 = document.getElementById("Jmeno").value;
	var input2 = document.getElementById("Prijmeni").value;
	var input3 = document.getElementById("Mail").value;
	var output0 = input0.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9]/g, "");
    var output1 = input1.replace(/\s+/g, '');
    var output2 = input2.replace(/\s+/g, '');
	var output3 = input3.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9@\.]/g, "");
  document.getElementById("Alias").value = output0;
  document.getElementById("Jmeno").value = output1;
  document.getElementById("Prijmeni").value = output2;
  document.getElementById("Mail").value = output3;
}
