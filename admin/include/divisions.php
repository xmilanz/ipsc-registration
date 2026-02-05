<div class="modal fade" id="manage_divisions" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-warning" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-center">
                <h4 class="modal-title text-white w-100 fw-bold">Správa divizí</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered bg-white">
                        <thead>
                            <tr>
                                <th style="width:90px;">Zkratka</th>
                                <th>Název</th>
                                <th style="width:100px;" colspan="2" class="text-center">Akce</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $stmt = $conn->prepare("SELECT * from $table_divisions ORDER BY Id");
                            $stmt->execute();
                            $result_names = $stmt->get_result();
                            while ($line = $result_names->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td class="editable" data-table="<?= $table_divisions ?>" data-field="Name" data-id="<?= $line['Id'] ?>"><?= htmlspecialchars($line['Name']) ?></td>
                                    <td class="editable" data-table="<?= $table_divisions ?>" data-field="Value" data-id="<?= $line['Id'] ?>"><?= htmlspecialchars($line['Value']) ?></td>
                                    <td class="save-cell" data-id="<?= $line['Id'] ?>">
                                        <button class="btn btn-sm btn-success me-1" disabled><i class="bi bi-check-lg"></i></button>
                                        <button class="btn btn-sm btn-secondary" disabled><i class="bi bi-x-lg"></i></button>
                                        <a class="btn btn-sm btn-danger" href="./save.php?delete_division&name=<?= $line['Name']; ?>"><i class="bi bi-trash3 me-1"></i>Smazat</a>
                                    </td>
                                </tr>
                            <?php
                                $i++;
                            }
                            ?>
                            <form class="needs-validation" method="post" action="./save.php" validate>
                                <tr>
                                    <td><input class="form-control" type="text" name="Name" id="Name" placeholder="OPN, REV,..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'OPN, REV,...'" onkeypress="return avoidspace(event)" required></td>
                                    <td><input class="form-control" type="text" name="Value" id="Value" placeholder="Open, Revolver,..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Open, Revolver,...'" required></td>
                                    </td>
                                    <td class="text-center">
                                        <button type="submit" name="new_division" class="btn btn-sm btn-primary px-5 py-2"><i class="bi bi-plus-circle me-1"></i>Přidat</button>
                                    </td>
                                </tr>
                            </form>
                        </tbody>
                    </table>
                </div>
                    <div id="accordion" class="col-md-12 mt-3">
                        <div class="card">
                            <a class="collapsed card-link" data-bs-toggle="collapse" href="#collapse">
                                <div class="card-header fw-bolder ">Seznam dostupných divizí</div>
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
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = 'index.php';">Zavřít</button>
            </div>
        </div>
    </div>
</div>