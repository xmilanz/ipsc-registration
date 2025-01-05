<?php include "header.php";

echo "
<div class='text-center'>
	<img src='./images/EC_ASCII.png'>
</div>

<div class='row modal fade' id='regInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
	  <div class='modal-content'>
		<div class='modal-header bg-danger text-center'>
			<h4 class='modal-title text-white w-100 font-weight-bold py-2'>Přihlášení do administrace závodu</h4><br>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close' onclick=\"window.location.href = 'index.php';\">
			<span aria-hidden='true' class='text-white'>&times;</span>
			</button>
		</div>
		<div class='modal-body text-center'>
		<form class='row needs-validation mb-0' method='post' action='./authenticate.php' >
			<div class='col-md-2'></div>	
			<div class='col-md-8'>	
				<div class='input-group form-group'>
					<div class='input-group-prepend'>
						<span class='input-group-text'><i class='fas fa-user'></i></span>
					</div>
					<input type='text' class='form-control' id='username' name='username' placeholder='uživatel'   onfocus=\"this.placeholder = ''\" onblur=\"this.placeholder = 'uživatel'\"  required>
				</div>
				<div class='input-group form-group'>
					<div class='input-group-prepend'>
						<span class='input-group-text'><i class='fas fa-key'></i></span>
					</div>
					<input type='password' class='form-control' id='password' name='password'  placeholder='heslo'  onfocus=\"this.placeholder = ''\" onblur=\"this.placeholder = 'heslo'\"  required>
				</div>
			</div>
			<div class='modal-footer border-top-0 col-12'>
				<button type='submit' class='btn btn-danger'>Přihlásit</button>
				<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'index.php';\">Zrušit</button>
			</div>
		</form>
		</div>
   </div>
 </div>
</div>

<script  type='text/javascript'>
var myModal = new bootstrap.Modal(document.getElementById('regInfo'));
	myModal.show();
    backdrop: 'static',
    keyboard: false
</script>

<script  type='text/javascript'>
	$('#regInfo').modal({
		backdrop: 'static',
		keyboard: false
	})
</script>
";

include "footer.php"; ?>

