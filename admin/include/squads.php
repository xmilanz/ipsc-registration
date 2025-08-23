<div class="modal fade" id="manage_squads" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-labelledby="myModalLabel"  aria-hidden="true">
   <div class="modal-dialog modal-notify modal-warning" role="document">
      <!--Content-->
      <div class="modal-content">
         <!--Header-->
         <div class="modal-header bg-success text-center">
            <h4 class="modal-title text-white w-100 fw-bold">Správa squadů</h4>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="col-md-12">
               <table class="table table-striped table-bordered bg-white">
                  <?php
                     $i=0;
                     $stmt = $conn->prepare("SELECT * from $table_squads ORDER BY Number");
                     $stmt->execute();
                     $result_names = $stmt->get_result();
                     while ($line = $result_names->fetch_assoc()) {
                  ?>
                  <tr>
                     <td width="25px"><?php echo $line["Number"]; ?></td>
                     <td><?php echo $line["Name"]; ?></td>
                     <td width="50px"><a class="btn btn-sm btn-danger" href="./save.php?delete_squad&number=<?php echo $line["Number"]; ?>">Smazat</a></td>
                  </tr>
                  <?php
                     $i++;
                     }
                  ?>
               </table>
            </div>
            <form class="row needs-validation" method="post" action="./save.php?new_squad"  novalidate>
               <div class="col-md-3">
                  <input class="form-control" type="text" name="Number" id="Number" placeholder="101, 102, ..." onfocus="this.placeholder = ''" onblur="this.placeholder = '101, 102, ...'" onkeypress="return avoidspace(event)" required>
                  <div class="invalid-feedback">Nevyplnili jste číslo squadu</div>
               </div>
               <div class="col-md-7">
                  <input class="form-control" type="text" name="Name" id="Name" placeholder="Squad 101, Squad 102, ..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Squad 101, Squad 102, ...'" required>
                  <div class="invalid-feedback">Nevyplnili jste název squadu</div>
               </div>
               <div class="col-md-2">
                  <button type="submit" class="btn btn-success">Přidat</button>
               </div>
               <div id="accordion" class="col-md-12 mt-3">
                  <div class="card">
                     <a class="collapsed card-link" data-bs-toggle="collapse" href="#collapse">
                        <div class="card-header fw-bolder ">Příklad pro dvě směny (101... dopolední, 201... odpolední)</div>
                     </a>
                     <div id="collapse" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-md-6">
                                 <dl class="row  text-start">
                                    <dt class="col-3 text-end pe-0">-9</dt>
                                    <dd class="col-9 ps-2">VYŘAZENO</dd>
                                    <dt class="col-3 text-end pe-0">-2</dt>
                                    <dd class="col-9 ps-2">Čekatelé</dd>
                                    <dt class="col-3 text-end pe-0"></dt>
                                    <dd class="col-9 ps-2"></dd>
                                    <dt class="col-3 text-end pe-0">100</dt>
                                    <dd class="col-9 ps-2">Squad 101</dd>
                                    <dt class="col-3 text-end pe-0">101</dt>
                                    <dd class="col-9 ps-2">Squad 101</dd>
                                    <dt class="col-3 text-end pe-0">102</dt>
                                    <dd class="col-9 ps-2">Squad 102</dd>
                                    <dt class="col-3 text-end pe-0">103</dt>
                                    <dd class="col-9 ps-2">Squad 103</dd>
                                    <dt class="col-3 text-end pe-0">104</dt>
                                    <dd class="col-9 ps-2">Squad 104</dd>
                                    <dt class="col-3 text-end pe-0"></dt>
                                    <dd class="col-9 ps-2"></dd>
                                    <dt class="col-3 text-end pe-0">201</dt>
                                    <dd class="col-9 ps-2">Squad 201</dd>
                                    <dt class="col-3 text-end pe-0">202</dt>
                                    <dd class="col-9 ps-2">Squad 202</dd>
                                    <dt class="col-3 text-end pe-0">203</dt>
                                    <dd class="col-9 ps-2">Squad 203</dd>
                                    <dt class="col-3 text-end pe-0">204</dt>
                                    <dd class="col-9 ps-2">Squad 204</dd>
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