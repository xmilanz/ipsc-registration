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
	var input1 = document.getElementById("alias-2").value;
	var input2 = document.getElementById("alias101").value;
	var input3 = document.getElementById("alias102").value;
	var input4 = document.getElementById("alias103").value;
	var input5 = document.getElementById("alias104").value;
	var input6 = document.getElementById("alias105").value;
	var input7 = document.getElementById("alias106").value;
	var input8 = document.getElementById("alias107").value;
	var input9 = document.getElementById("alias108").value;
	var input10 = document.getElementById("email-2").value;
	var input11 = document.getElementById("email101").value;
	var input12 = document.getElementById("email102").value;
	var input13 = document.getElementById("email103").value;
	var input14 = document.getElementById("email104").value;
	var input15 = document.getElementById("email105").value;
	var input16 = document.getElementById("email106").value;
	var input17 = document.getElementById("email107").value;
	var input18 = document.getElementById("email108").value;

	var output1 = input1.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9]/g, "");
	var output2 = input2.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9]/g, "");
	var output3 = input3.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9]/g, "");
	var output4 = input4.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9]/g, "");
	var output5 = input5.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9]/g, "");
	var output6 = input6.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9]/g, "");
	var output7 = input7.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9]/g, "");
	var output8 = input8.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9]/g, "");
	var output9 = input9.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9]/g, "");
	var output10 = input10.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9@\.]/g, "");
	var output11 = input11.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9@\.]/g, "");
	var output12 = input12.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9@\.]/g, "");
	var output13 = input13.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9@\.]/g, "");
	var output14 = input14.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9@\.]/g, "");
	var output15 = input15.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9@\.]/g, "");
	var output16 = input16.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9@\.]/g, "");
	var output17 = input17.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9@\.]/g, "");
	var output18 = input18.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9@\.]/g, "");

	document.getElementById("alias-2").value = output1;
	document.getElementById("alias101").value = output2;
	document.getElementById("alias102").value = output3;
	document.getElementById("alias103").value = output4;
	document.getElementById("alias104").value = output5;
	document.getElementById("alias105").value = output6;
	document.getElementById("alias106").value = output7;
	document.getElementById("alias107").value = output8;
	document.getElementById("alias108").value = output9;
	document.getElementById("email-2").value = output10;
	document.getElementById("email101").value = output11;
	document.getElementById("email102").value = output12;
	document.getElementById("email103").value = output13;
	document.getElementById("email104").value = output14;
	document.getElementById("email105").value = output15;
	document.getElementById("email106").value = output16;
	document.getElementById("email107").value = output17;
	document.getElementById("email108").value = output18;
}

function avoidspace(event) {
    var k = event ? event.which : window.event.keyCode;
    if (k == 32) return false;
}
