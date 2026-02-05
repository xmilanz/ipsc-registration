<?php
function WarningModalForm(
    string $Header = '',
    string $CloseHref = '',
    array $HiddenFields = [],
    string $Message = '',
    string $ExtraInfo = '',
    string $ActionURL = '',
    string $FormAction = '',
    string $SubmitLabel = 'Potvrdit',
    string $CancelLabel = 'Zrušit'
): void {

    $WarnHeader = htmlspecialchars($Header, ENT_QUOTES, 'UTF-8');
    $WarnCloseHref = htmlspecialchars($CloseHref, ENT_QUOTES, 'UTF-8');
    $WarnActionURL = htmlspecialchars($ActionURL, ENT_QUOTES, 'UTF-8');
    $WarnAction = htmlspecialchars($FormAction, ENT_QUOTES, 'UTF-8');
    $WarnMessage = $Message;
    $WarnExtraInfo = $ExtraInfo;

    echo "
    <div class='text-center'>
        <img src='./images/bkg_eggenberg.png'>
    </div>
    <div id='myModal' class='row modal fade' tabindex='-1'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header bg-danger text-center'>
                    <h4 class='modal-title text-white w-100 fw-bold py-2'>$WarnHeader</h4><br>
                    <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal' aria-label='Close' onclick=\"window.location.href = '$WarnCloseHref';\"></button>
                </div>
                <div class='modal-body text-center'>
                    <form class='row needs-validation mb-0' method='post' action='$WarnActionURL'>
    ";

    // Skryté inputy (např. ID a klic)
    foreach ($HiddenFields as $name => $value) {
        $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $safeValue = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        echo "<input type='hidden' name='$safeName' value='$safeValue'>";
    }

    echo "
        <div class='col-12 mb-3 fw-bolder text-danger'>
            $WarnMessage
        </div>
        <div class='col-12 text-center'>
            <div class='bd-callout-info m-1'>
                <i class='far fa-info-circle pe-2' style='font-size:12px'></i>$WarnExtraInfo
            </div>
        </div>
                </div>
                <div class='modal-footer border-top-0 col-12'>
                    <button type='submit' name='$WarnAction' class='btn btn-danger'>$SubmitLabel</button>
                    <button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = '$WarnCloseHref';\">$CancelLabel</button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <script type='text/javascript'>
    $(document).ready(function(){
        $('#myModal').modal('show');
    });
    </script>
    ";
}
