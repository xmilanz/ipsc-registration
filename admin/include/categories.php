<div class="modal fade" id="manage_categories" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel"  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-warning" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header bg-success text-center">
        <h4 class="modal-title text-white w-100 font-weight-bold">Správa kategorií</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>

      </div>
      <div class="modal-body">
		<div class="col-md-12">
			<table class="table table-striped table-bordered bg-white">
				<?php
				$i=0;
				$query = "SELECT * from $table_categories";
				$result = mysql_query($query);
					while($row = mysql_fetch_array($result)) {
					?>
					<tr>
						<td width="65px"><?php echo $row["Name"]; ?></td>
						<td><?php echo $row["Value"]; ?></td>
						<td width="50px"><a class="btn btn-sm btn-danger" href="./save.php?delete_category&category=<?php echo $row["Name"]; ?>">Smazat</a></td>
					</tr>
					<?php
					$i++;
					}
				?>
			</table>
		</div>
		<form class="row needs-validation" method="post" action="./save.php?new_category"  novalidate>
			<div class="col-md-3 ml-3">
				<input class="form-control" type="text" name="Name" id="Name" placeholder="REGULAR, SSENIOR,..." onfocus="this.placeholder = ''" onblur="REGULAR, SSENIOR,..." onkeypress="return avoidspace(event)" required>
				<div class="invalid-feedback">Nevyplnili jste název</div>
			  </div>
			<div class="col-md-6 pl-0">
				<input class="form-control" type="text" name="Value" id="Value" placeholder="Regular, Super Senior,..." onfocus="this.placeholder = ''" onblur="Regular, Super Senior,..." required>
				<div class="invalid-feedback">Nevyplnili jste hodnotu</div>
			</div>
			<div class="col-md-2">
				<button type="submit" class="btn btn-success">Přidat</button>
			</div>

			<div id="accordion" class="col-md-12 mt-3 ml-3 pr-5">
				<div class="card">
				<a class="collapsed card-link" data-toggle="collapse" href="#collapse">
					<div class="card-header font-weight-bolder ">Seznam použitelných kategorií</div>
				</a>
				<div id="collapse" class="collapse" data-parent="#accordion">
					<div class="card-body">
					<div class="row">
					<div class="col-md-6">
						<dl class="row  text-left">
							<dt class="col-6 text-right pr-0">REGULAR</dt><dd class="col-6 pl-2">Regular</dd>
							<dt class="col-6 text-right pr-0">SENIOR</dt><dd class="col-6 pl-2">Senior</dd>
							<dt class="col-6 text-right pr-0">SSENIOR</dt><dd class="col-6 pl-2">Super senior</dd>
							<dt class="col-6 text-right pr-0">GSENIOR</dt><dd class="col-6 pl-2">Grand senior</dd>
							<dt class="col-6 text-right pr-0">LADY</dt><dd class="col-6 pl-2">Lady</dd>
							<dt class="col-6 text-right pr-0">Junior</dt><dd class="col-6 pl-2">Junior</dd>
						</dl>
					</div>
					</div>
				</div>
				</div>
		
				</div>
			</div>
		</form>
	</div>

	
      <!--Footer-->
		<div class="modal-footer border-top-0">
			<button type="button" class="btn btn-outline-dark" data-dismiss="modal" aria-label="Close">Zavřít</button>
		</div>
    </div>
    <!--/.Content-->
  </div>
</div>
	<a href="" class="btn btn-success btn-rounded mr-3" data-toggle="modal" data-target="#manage_categories">Správa kategorií</a>
</div>
</div>
<br>
