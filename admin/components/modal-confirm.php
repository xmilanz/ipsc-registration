<?php
function ConfirmModal(
    string $Color = 'warning',
    string $Header = '',
    string $Action = '',
    array $HiddenFields = [],
    string $Message = '',
    string $Info = '',
    string $ConfirmLabel = 'Potvrdit',
    string $CancelHref = 'index.php',
    string $CancelLabel = 'Zrušit'
): void {
    $color = htmlspecialchars($Color, ENT_QUOTES, 'UTF-8');
    $header = htmlspecialchars($Header, ENT_QUOTES, 'UTF-8');
    $action = htmlspecialchars($Action, ENT_QUOTES, 'UTF-8');
    $confirmLabel = htmlspecialchars($ConfirmLabel, ENT_QUOTES, 'UTF-8');
    $cancelHref = htmlspecialchars($CancelHref, ENT_QUOTES, 'UTF-8');
    $cancelLabel = htmlspecialchars($CancelLabel, ENT_QUOTES, 'UTF-8');

    echo "
    <div id='confirmModal' class='row modal fade' tabindex='-1'>
        <div class='modal-dialog'>
            <div class='modal-content text-center'>
                <div class='modal-header bg-$color'>
                    <h4 class='modal-title text-white w-100 fw-bold py-2'>$header</h4>
                    <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal' aria-label='Close' onclick=\"window.location.href = '$cancelHref';\"></button>
                </div>
                <form method='post' action='$action'>
                    <div class='modal-body text-center'>
                        <div class='col-12 mb-2 fw-bolder text-$color'>
                            $Message
                        </div>
                        <div class='col-12 small'>
                            <i class='far fa-info-circle pe-2 mt-3'></i><i>$Info</i>
                        </div>";

    foreach ($HiddenFields as $key => $value) {
        $keyEsc = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
        $valEsc = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        echo "<input type='hidden' name='$keyEsc' value='$valEsc'>";
    }

    echo "      </div>
                    <div class='modal-footer border-top-0 col-12'>
                        <button type='submit' class='btn btn-$color'>$confirmLabel</button>
                        <a href='$cancelHref' class='btn btn-outline-dark'>$cancelLabel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type='text/javascript'>
        var confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
        confirmModal.show();
    </script>
    ";
}
