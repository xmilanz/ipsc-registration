<?php
include("./header.php");

session_start();
$_SESSION['token'] = bin2hex(random_bytes(32));

$shooterID = intval($_GET['id']);
$shooterKEY = intval($_GET['klic']);

$line = getShooterData($conn, $table, $shooterID, $shooterKEY);

// NELZE DOHLEDAT ZAVODNIKA
if (!$line) {
    include './components/modal-warning.php';
    WarningModal(
        "Vyřazení závodníka",
        "index.php",
        "<div class='col-12 fw-bolder text-danger'>Nelze dohledat závodníka v databázi",
        "Kontaktujte <a href='mailto:" . htmlspecialchars($vyvojar, ENT_QUOTES, 'UTF-8') . "?subject=" . htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') . " - chyba dohledání zavodnika'>pořadatele závodu</a>.",
        "<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'index.php';\">Zavřít</button>",
        "$poradatel"
    );
    exit;
}

// ZÁVODNÍK UŽ JE VYŘAZENÝ (Squad je -9)
if ($line['Squad'] == '-9') {
    include './components/modal-warning.php';
    WarningModal(
        "Vyřazení závodníka",
        "index.php",
        "<div class='col-12 fw-bolder text-danger'>Závodník #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . " (" . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . ") je už vyřazený.",
        "Pokud jste tuto akci neprovedli, neprodleně nás kontaktujte.",
        "<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'index.php';\">Zavřít</button>",
        "$poradatel"
    );
    exit;
}

// KONEČNĚ VYŘAZUJEME
else {
    include './components/modal-warning-form.php';
    WarningModalForm(
        "Vyřazení závodníka",
        "index.php",
        [
            "shooterID" => $shooterID,
            "shooterKEY" => $shooterKEY
        ],
        "Závodník #" . $line['Cislo'] . " " . htmlspecialchars($line['Jmeno'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($line['Prijmeni'], ENT_QUOTES, 'UTF-8') . " (" . htmlspecialchars($line['Alias'], ENT_QUOTES, 'UTF-8') . ") bude vyřazen.",
        "Pokud jste provedli platbu registračního poplatku,<br>můžete místo vyřazení přenést startovné na jiného závodníka.",
        "./save.php",
        "cancel_shooter",
        "Vyřadit závodníka",
        "$poradatel"
    );
}
