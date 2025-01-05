<div class="modal fade" id="manage_categories" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel"  aria-hidden="true">
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
						<td><?php echo $row["Name"]; ?></td>
						<td width="50px"><a class="btn btn-sm btn-danger" href="./save.php?delete_category&category=<?php echo $row["Name"]; ?>">Smazat</a></td>
					</tr>
					<?php
					$i++;
					}
				?>
			</table>
		</div>
		<form class="row needs-validation" method="post" action="./save.php?new_category"  novalidate>
			<div class="col-md-9 ml-3">
				<input class="form-control" type="text" name="Name" id="Name" placeholder="REGULAR, SSENIOR,..." onfocus="this.placeholder = ''" onblur="REGULAR, SSENIOR,..." onkeypress="return avoidspace(event)" required>
				<div class="invalid-feedback">Nevyplnili jste název</div>
			  </div>
			<div class="col-md-2">
				<button type="submit" class="btn btn-success">Přidat</button>
			</div>

			<div id="accordion" class="col-md-12 mt-3 ml-3 pr-5">
				<div class="card">
				<a class="collapsed card-link" data-toggle="collapse" href="#collapse">
					<div class="card-header font-weight-bolder ">Seznam všech kategorií</div>
				</a>
				<div id="collapse" class="collapse" data-parent="#accordion">
					<div class="card-body">
					<div class="row">
					<div class="col-md-10">
						<dl class="row  text-left">
							<dt class="col-3 text-right pr-0">REGULAR</dt><dd class="col-9 pl-2">(18 - 49)</dd>
							<dt class="col-3 text-right pr-0">SENIOR</dt><dd class="col-9 pl-2">Senior (50 - 59)</dd>
							<dt class="col-3 text-right pr-0">SSENIOR</dt><dd class="col-9 pl-2">Super Senior (60 - 69)</dd>
							<dt class="col-3 text-right pr-0">GSENIOR</dt><dd class="col-9 pl-2">Grand Senior (starší 70 let)</dd>
							<dt class="col-3 text-right pr-0">LADY</dt><dd class="col-9 pl-2">Lady (závodnice ženského pohlaví)</dd>
							<dt class="col-3 text-right pr-0">LSENIOR</dt><dd class="col-9 pl-2">Super Lady (starší 50 let)</dd>
							<dt class="col-3 text-right pr-0">JUNIOR</dt><dd class="col-9 pl-2">Junior (14 - 17)</dd>
							<dt class="col-3 text-right pr-0">SJUNIOR</dt><dd class="col-9 pl-2">Super Junior (mladší 14 let)</dd>
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
	<!--a href="" class="nav-link" data-toggle="modal" data-target="#manage_categories">Kategorie</a-->
	
