<div class="modal fade" id="manage_categories" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-labelledby="myModalLabel"  aria-hidden="true">
   <div class="modal-dialog modal-notify modal-warning" role="document">
      <!--Content-->
      <div class="modal-content">
         <!--Header-->
         <div class="modal-header bg-success text-center">
            <h4 class="modal-title text-white w-100 fw-bold">Správa kategorií</h4>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="col-md-12">
               <table class="table table-striped table-bordered bg-white">
                  <?php
                     $i=0;
                     $stmt = $conn->prepare("SELECT * from $table_categories ORDER BY Id");
                     $stmt->execute();
                     $result_names = $stmt->get_result();
                     while ($line = $result_names->fetch_assoc()) {
                     	?>
                  <tr>
                     <td width="25px"><?php echo $line["Name"]; ?></td>
                     <td><?php echo $line["Value"]; ?></td>
                     <td width="50px"><a class="btn btn-sm btn-danger" href="./save.php?delete_category&name=<?php echo $line["Name"]; ?>">Smazat</a></td>
                  </tr>
                  <?php
                     $i++;
                     }
                     ?>
               </table>
            </div>
            <form class="row needs-validation" method="post" action="./save.php?new_category"  novalidate>
               <div class="col-md-3">
                  <input class="form-control" type="text" name="Name" id="Name" placeholder="REGULAR,..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'REGULAR,...'" onkeypress="return avoidspace(event)" required>
                  <div class="invalid-feedback">Nevyplnili jste název</div>
               </div>
               <div class="col-md-7">
                  <input class="form-control" type="text" name="Value" id="Value" placeholder="Regular (18 - 49),..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Regular (18 - 49),...'" required>
                  <div class="invalid-feedback">Nevyplnili jste popis</div>
                </div>

               <div class="col-md-2">
                  <button type="submit" class="btn btn-success">Přidat</button>
               </div>
               <div id="accordion" class="col-md-12 mt-3">
                  <div class="card">
                     <a class="collapsed card-link" data-bs-toggle="collapse" href="#collapse">
                        <div class="card-header fw-bolder ">Seznam všech kategorií</div>
                     </a>
                     <div id="collapse" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-md-10">
                                 <dl class="row  text-start">
                                    <dt class="col-3 text-end pe-0">REGULAR</dt>
                                    <dd class="col-9 ps-2">(18 - 49)</dd>
                                    <dt class="col-3 text-end pe-0">SENIOR</dt>
                                    <dd class="col-9 ps-2">Senior (50 - 59)</dd>
                                    <dt class="col-3 text-end pe-0">SSENIOR</dt>
                                    <dd class="col-9 ps-2">Super Senior (60 - 69)</dd>
                                    <dt class="col-3 text-end pe-0">GSENIOR</dt>
                                    <dd class="col-9 ps-2">Grand Senior (starší 70 let)</dd>
                                    <dt class="col-3 text-end pe-0">LADY</dt>
                                    <dd class="col-9 ps-2">Lady (závodnice ženského pohlaví)</dd>
                                    <dt class="col-3 text-end pe-0">LSENIOR</dt>
                                    <dd class="col-9 ps-2">Super Lady (starší 50 let)</dd>
                                    <dt class="col-3 text-end pe-0">JUNIOR</dt>
                                    <dd class="col-9 ps-2">Junior (14 - 17)</dd>
                                    <dt class="col-3 text-end pe-0">SJUNIOR</dt>
                                    <dd class="col-9 ps-2">Super Junior (mladší 14 let)</dd>
                                 </dl>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer border-top-0">
            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = 'index.php';">Zavřít</button>
         </div>
      </div>
   </div>
</div>