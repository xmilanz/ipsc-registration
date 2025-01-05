<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

require_once ("../config/data.php");

$ID=$_GET['ID'];
$query="SELECT * FROM ".$table." WHERE Cislo=$ID";
$res=mysql_query($query);
$line=mysql_fetch_array($res);
?>
      <div class="modal-header bg-danger text-center">
		<h4 class="modal-title text-white w-100 font-weight-bold py-2">Mazání závodníka</h4><br>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.href = 'index.php';">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
	  </div>
      <div class="modal-body text-center">
		<form class="row needs-validation mb-0" method="post" action="./save.php?delete_shooter" >
	  <!-- ID závodníka -->
		<INPUT type="hidden" id="shooterID" name="shooterID" value="<?php echo "$ID";?>" required>
	  <!-- ID závodníka -->
	  <div class="col-12 mb-3 font-weight-bolder text-danger">
		Skutečně chcete smazat závodníka <?php echo "$line[Jmeno] $line[Prijmeni] ($line[Cislo])";?>?
	  </div>
	  <div class="col-12 font-weight-bolder">
		Tato akce je nevratná, rozmyslete si to pořádně!!!
	  </div>
	<div class="modal-footer border-top-0 mt-3 col-12">
		<button type="submit" class="btn btn-danger">Smazat závodníka</button>
		<button type="button" class="btn btn-default" onclick="window.location.href = 'index.php';">Zrušit</button>
	</div>
	 </form>
