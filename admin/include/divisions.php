<div class="modal fade" id="manage_divisions" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-labelledby="myModalLabel"  aria-hidden="true">
   <div class="modal-dialog modal-notify modal-warning" role="document">
      <!--Content-->
      <div class="modal-content">
         <!--Header-->
         <div class="modal-header bg-success text-center">
            <h4 class="modal-title text-white w-100 fw-bold">Správa divizí</h4>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="col-md-12">
               <table class="table table-striped table-bordered bg-white">
                  <?php
                     $i=0;
                     $stmt = $conn->prepare("SELECT * from $table_divisions ORDER BY Id");
                     $stmt->execute();
                     $result_names = $stmt->get_result();
                     while ($line = $result_names->fetch_assoc()) {
                  ?>
                  <tr>
                     <td width="25px"><?php echo $line["Name"]; ?></td>
                     <td><?php echo $line["Value"]; ?></td>
                     <td width="50px">    <a class="btn btn-sm btn-danger" href="./save.php?delete_division&name=<?php echo $line["Name"]; ?>">Smazat</a></td>
                  </tr>
                  <?php
                     $i++;
                     }
                     ?>
               </table>
            </div>
            <form class="row needs-validation" method="post" action="./save.php?new_division"  novalidate>
               <div class="col-md-3">
                  <input class="form-control" type="text" name="Name" id="Name" placeholder="OPN, REV,..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'OPN, REV,...'" onkeypress="return avoidspace(event)" required>
                  <div class="invalid-feedback">Nevyplnili jste název</div>
               </div>
               <div class="col-md-7">
                  <input class="form-control" type="text" name="Value" id="Value" placeholder="Open, Revolver,..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Open, Revolver,...'" required>
                  <div class="invalid-feedback">Nevyplnili jste hodnotu</div>
               </div>
               <div class="col-md-2">
                  <button type="submit" class="btn btn-success" >Přidat</button>
               </div>
               <div id="accordion" class="col-md-12 mt-3">
                  <div class="card">
                     <a class="collapsed card-link" data-bs-toggle="collapse" href="#collapse">
                        <div class="card-header fw-bolder ">Seznam všech divizí</div>
                     </a>
                     <div id="collapse" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-md-6">
                                 <dl class="row  text-start">
                                    <dt class="col-3 text-end pe-0">PRD</dt>
                                    <dd class="col-9 ps-2">Production</dd>
                                    <dt class="col-3 text-end pe-0">PDO</dt>
                                    <dd class="col-9 ps-2">Production Optics</dd>
                                    <dt class="col-3 text-end pe-0">STD</dt>
                                    <dd class="col-9 ps-2">Standard</dd>
                                    <dt class="col-3 text-end pe-0">SDO</dt>
                                    <dd class="col-9 ps-2">Standard Optics</dd>
                                    <dt class="col-3 text-end pe-0">OPN</dt>
                                    <dd class="col-9 ps-2">Open</dd>
                                    <dt class="col-3 text-end pe-0">CLA</dt>
                                    <dd class="col-9 ps-2">Classic</dd>
                                    <dt class="col-3 text-end pe-0">REV</dt>
                                    <dd class="col-9 ps-2">Revolver</dd>
                                    <dt class="col-3 text-end pe-0">RE6</dt>
                                    <dd class="col-9 ps-2">Revolver (šestiraňák)</dd>
                                    <dt class="col-3 text-end pe-0">PCC</dt>
                                    <dd class="col-9 ps-2">PCC</dd>
                                    <dt class="col-3 text-end pe-0">PCCI</dt>
                                    <dd class="col-9 ps-2">PCC Iron</dd>
                                    <dt class="col-3 text-end pe-0">PCCO</dt>
                                    <dd class="col-9 ps-2">PCC Optics</dd>
                                    <dt class="col-3 text-end pe-0">MR</dt>
                                    <dd class="col-9 ps-2">Mini Rifle</dd>
                                    <dt class="col-3 text-end pe-0">MRS</dt>
                                    <dd class="col-9 ps-2">Mini Rifle Standard</dd>
                                    <dt class="col-3 text-end pe-0">MRO</dt>
                                    <dd class="col-9 ps-2">Mini Rifle Open</dd>
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
            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = 'index.php';">Zavřít</button>
         </div>
      </div>
      <!--/.Content-->
   </div>
</div>