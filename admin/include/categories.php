<div class="modal fade" id="manage_categories" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-warning" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-center">
                <h4 class="modal-title text-white w-100 fw-bold">Správa kategorií</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered bg-white">
                        <thead>
                            <tr>
                                <th style="width:90px;">Zkratka</th>
                                <th>Název</th>
                                <th style="width:100px;" colspan="3" class="text-center">Akce</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $stmt = $conn->prepare("SELECT * from $table_categories ORDER BY Id");
                            $stmt->execute();
                            $result_names = $stmt->get_result();
                            while ($line = $result_names->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td class="editable" data-table="<?= $table_categories ?>" data-field="Name" data-id="<?= $line['Id'] ?>"><?= htmlspecialchars($line['Name']) ?></td>
                                    <td class="editable" data-table="<?= $table_categories ?>" data-field="Value" data-id="<?= $line['Id'] ?>"><?= htmlspecialchars($line['Value']) ?></td>
                                    <td class="save-cell" data-id="<?= $line['Id'] ?>">
                                        <button class="btn btn-sm btn-success me-1" disabled><i class="bi bi-check-lg"></i></button>
                                        <button class="btn btn-sm btn-secondary" disabled><i class="bi bi-x-lg"></i></button>
                                        <a class="btn btn-sm btn-danger" href="./save.php?delete_category&name=<?= $line['Name']; ?>"><i class="bi bi-trash3 me-1"></i>Smazat</a>
                                    </td>
                                </tr>

                            <?php
                                $i++;
                            }
                            ?>
                            <form class="needs-validation" method="post" action="./save.php" validate>
                                <tr>
                                    <td><input class="form-control" type="text" name="Name" id="Name" placeholder="REGULAR,..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'REGULAR,...'" onkeypress="return avoidspace(event)" required></td>
                                    <td><input class="form-control" type="text" name="Value" id="Value" placeholder="Regular (18 - 49),..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Regular (18 - 49),...'" required></td>
                                    </td>
                                    <td class="text-center">
                                        <button type="submit" name="new_category" class="btn btn-sm btn-primary px-5 py-2"><i class="bi bi-plus-circle me-1"></i>Přidat</button>
                                    </td>
                                </tr>
                            </form>
                        </tbody>

                    </table>
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
                                            <dd class="col-9 ps-2">Lady</dd>
                                            <dt class="col-3 text-end pe-0">LSENIOR</dt>
                                            <dd class="col-9 ps-2">Lady Senior (starší 50 let)</dd>
                                            <dt class="col-3 text-end pe-0">JUNIOR</dt>
                                            <dd class="col-9 ps-2">Junior (do 21 let)</dd>
                                            <dt class="col-3 text-end pe-0">SJUNIOR</dt>
                                            <dd class="col-9 ps-2">Super Junior (do 18 let)</dd>
                                            <dt class="col-3 text-end pe-0">GJUNIOR</dt>
                                            <dd class="col-9 ps-2">Grand Junior (do 14 let)</dd>
                                            <dt class="col-3 text-end pe-0">LJUNIOR</dt>
                                            <dd class="col-9 ps-2">Lady Junior (do 21 let)</dd>
                                            <dt class="col-3 text-end pe-0">LSJUNIOR</dt>
                                            <dd class="col-9 ps-2">Lady Super Junior (do 18 let)</dd>
                                            <dt class="col-3 text-end pe-0">LGJUNIOR</dt>
                                            <dd class="col-9 ps-2">Lady Grand Junior (do 14 let)</dd>
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