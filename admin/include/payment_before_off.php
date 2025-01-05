<?php 
	$query = "SELECT * from match_config where Zavod_id='$table'";
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	$match_configuration = mysql_fetch_array($result);
?>


<div class="modal fade" id="payment_before_off" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel"  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-warning" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header bg-success text-center">
        <h4 class="modal-title text-white w-100 font-weight-bold py-2">Způsob placení závodu</h4><br>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
	  <!--Body-->
      <div class="modal-body text-center">
		<form class="row needs-validation mb-0" method="post" action="./save.php?payment_before_off" >
	  <!-- ID závodníka -->
		<INPUT type="hidden" id="shooterID" name="shooterID" value="<?php echo "$ID";?>" required>
	  <!-- ID závodníka -->
	  <div class="col-12 mb-3 font-weight-bolder text-danger">
		Aktuálně musí závodník uhradit startovné do 10 dní od registrace.
	  </div>
	  <div class="col-12 font-weight-bolder">
		Chcete nastavit závod tak, aby se startovné platilo <br>na místě při prezenci?
	  </div>
      </div>
	  <!--Body-->
      <!--Footer-->
		<div class="modal-footer border-top-0">
			<button type="submit" class="btn btn-success">Zapnout placení na místě</button>
			<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Zrušit</button>
		</div>
	 </form>
    </div>
	<!--Content-->
  </div>
  </div>
</div>
	<a href="" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#payment_before_off">Zapnout placení na místě</a>
</div>
</div>
</div>