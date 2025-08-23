<?php
function WarningModalForm(
    string $Color = '',
    string $Header = '',
    string $CloseHref = '',
    array $HiddenFields = [],
    string $Message = '',
    string $ExtraInfo = '',
    string $FormActionURL = '',
    string $SubmitLabel = 'Potvrdit',
    string $CancelLabel = 'Zrušit'
): void {

    // Ošetření vstupů pro bezpečnost
    $WarnColor = htmlspecialchars($Color, ENT_QUOTES, 'UTF-8');
    $WarnHeader = htmlspecialchars($Header, ENT_QUOTES, 'UTF-8');
    $WarnCloseHref = htmlspecialchars($CloseHref, ENT_QUOTES, 'UTF-8');
    $WarnActionURL = htmlspecialchars($FormActionURL, ENT_QUOTES, 'UTF-8');
    $WarnMessage = $Message;         // HTML (např. obsah s jménem),
    $WarnExtraInfo = $ExtraInfo;     // HTML (např. poznámka, ikona)

    // Hlavička
    echo "
        <div class='modal-header bg-$WarnColor text-center'>
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

    // Obsah
    echo "
        <div class='col-12 mb-2 fw-bolder text-$WarnColor'>
            $WarnMessage
        </div>
        <div class='col-12 text-center mb-3'>
            <i class='far fa-info-circle pe-2' style='font-size:16px'></i><i>$WarnExtraInfo</i>
        </div>
        <div class='modal-footer border-top-0 col-12'>
            <button type='submit' class='btn btn-$WarnColor'>$SubmitLabel</button>
            <button type='button' class='btn btn-outline-dark' onclick=\"window.location.href = '$WarnCloseHref';\">$CancelLabel</button>
        </div>
            </form>
    ";
}