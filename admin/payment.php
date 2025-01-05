<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit;
}

require_once ("../config/data.php");

$ID=$_GET['ID'];
$KEY=$_GET['KEY'];
$query="SELECT * FROM ".$table." WHERE Cislo=$ID AND Klic=$KEY";
$res=mysql_query($query);
$line=mysql_fetch_array($res);
?>

     <div class="modal-header bg-success text-center">
		<h4 class="modal-title text-white w-100 font-weight-bold py-2">Evidence úhrady startovného</h4><br>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.href = 'index.php';">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
	  </div>
      <div class="modal-body text-center">
		<form class="row needs-validation mb-0" method="post" action="./save.php?mark_paid" >
	  <!-- ID závodnika a klic -->
		<INPUT type="hidden" id="shooterID" name="shooterID" value="<?php echo "$ID";?>" required>
		<INPUT type="hidden" id="shooterKEY" name="shooterKEY" value="<?php echo "$KEY";?>" required>
	  <!-- ID zavodnika a klic -->
	  <div class="col-12 mb-3 font-weight-bolder">
		Závodník <?php echo "$line[Jmeno] $line[Prijmeni] ($line[Cislo])";?> zaplatil.
	  </div>
	<div class="modal-footer border-top-0 mt-3 col-12">
		<button type="submit" class="btn btn-success">Zaevidovat platbu</button>
		<button type="button" class="btn btn-default" onclick="window.location.href = 'index.php';">Zrušit</button>
	</div>
	 </form>
