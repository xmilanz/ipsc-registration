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


function normalizeInput(value, field) {
  let output = value.trim();

  switch (field) {
    case 'Alias':
      output = output.normalize("NFD").replace(/[^a-zA-ZáÁčČďĎéÉěĚíÍňŇóÓřŘšŠťŤúÚůŮýÝžŽ]/g, "").toLowerCase();
      break;
    case 'Jmeno':
      output = output.replace(/[^a-zA-ZáÁčČďĎéÉěĚíÍňŇóÓřŘšŠťŤúÚůŮýÝžŽ]/g, "");
      break;
    case 'Prijmeni':
      output = output.replace(/[^a-zA-ZáÁčČďĎéÉěĚíÍňŇóÓřŘšŠťŤúÚůŮýÝžŽ0-9]/g, "");
      break;
    case 'Mail':
    case 'email':
      output = output.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9@\.]/g, "").toLowerCase();
      break;
    default:
      // Pro ostatní pole můžeš přidat další pravidla
      break;
  }

  return output;
}


function replaceChars() {
	var aliasInput = document.getElementById(`Alias`);
	if (aliasInput) {
		var inputAlias = aliasInput.value;
		var outputAlias = inputAlias.normalize("NFD").replace(/[^a-zA-ZáÁčČďĎéÉěĚíÍňŇóÓřŘšŠťŤúÚůŮýÝžŽ]/g, "");
		aliasInput.value = outputAlias;
	}

    var jmenoInput = document.getElementById(`Jmeno`);
	if (jmenoInput) {
		var inputJmeno = jmenoInput.value;
		var outputJmeno = inputJmeno.replace(/[^a-zA-ZáÁčČďĎéÉěĚíÍňŇóÓřŘšŠťŤúÚůŮýÝžŽ]/g, "");
		jmenoInput.value = outputJmeno;
	}

	var prijmeniInput = document.getElementById(`Prijmeni`);
	if (prijmeniInput) {
		var inputPrijmeni = prijmeniInput.value;
		var outputPrijmeni = inputPrijmeni.replace(/[^a-zA-ZáÁčČďĎéÉěĚíÍňŇóÓřŘšŠťŤúÚůŮýÝžŽ0-9]/g, "");
		prijmeniInput.value = outputPrijmeni;
	}

	var emailInput = document.getElementById(`Mail`);
	if (emailInput) {
		var inputEmail = emailInput.value;
		var outputEmail = inputEmail.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9@\.]/g, "");
		emailInput.value = outputEmail;
	}
}


function toggleDivize() {
    var pidivDalsi = document.getElementById("Divize_dalsi");
    var pidiv = document.getElementById("Divize");

    if (pidivDalsi.value) {
        pidiv.disabled = true; // Deaktivuje pole "Divize", pokud je vybrana hodnota v "Divize_dalsi"
    } else {
        pidiv.disabled = false; // Aktivuje pole "Divize", pokud je vybrana prazdna hodnota v "Divize_dalsi"
    }
}

function toggleDivizeMain() {
    var pidivDalsi = document.getElementById("Divize_dalsi");
    var pidiv = document.getElementById("Divize");

    if (pidiv.value) {
        pidivDalsi.disabled = true;
    } else {
        pidivDalsi.disabled = false;
    }
}
