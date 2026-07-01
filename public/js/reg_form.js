/* =======================================================
    DISABLE FORM SUBMISSIONS IF THERE ARE INVALID FIELDS
======================================================== */
(function () {
  'use strict';
    window.addEventListener('load', function () {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
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

/* =======================
    NÁHRADA ZNAKŮ 
======================== */
function replaceChars(index) {
	var jmenoInput = document.getElementById(`Jmeno${index}`);
	if (jmenoInput) {
		var inputJmeno = jmenoInput.value;
		var outputJmeno = inputJmeno.replace(/[^a-zA-ZáÁčČďĎéÉěĚíÍňŇóÓřŘšŠťŤúÚůŮýÝžŽ]/g, "");
		jmenoInput.value = outputJmeno;
	}

	var prijmeniInput = document.getElementById(`Prijmeni${index}`);
	if (prijmeniInput) {
		var inputPrijmeni = prijmeniInput.value;
		var outputPrijmeni = inputPrijmeni.replace(/[^a-zA-ZáÁčČďĎéÉěĚíÍňŇóÓřŘšŠťŤúÚůŮýÝžŽ0-9]/g, "");
		prijmeniInput.value = outputPrijmeni;
	}

	var emailInput = document.getElementById(`Email${index}`);
	if (emailInput) {
		var inputEmail = emailInput.value;
		var outputEmail = inputEmail.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z0-9@\.]/g, "");
		emailInput.value = outputEmail;
	}
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

/* =======================
    POPOVER 
======================== */
document.addEventListener("DOMContentLoaded", function () {
    const popovers = [];

    document.querySelectorAll('[data-bs-toggle="popover"]').forEach(function (el) {
        const popover = new bootstrap.Popover(el, {
            trigger: 'focus'
        });

        popovers.push(popover);

        el.addEventListener('show.bs.popover', function () {
            popovers.forEach(function (p) {
                if (p !== popover) {
                    p.hide();
                }
            });
        });
    });
});

