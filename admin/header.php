<?php
session_start();
$toast = $_SESSION['toast'] ?? null;
unset($_SESSION['toast']);

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}
require_once __DIR__ . '/../db/dbconn.php';

$result = $conn->query("SELECT * from match_config where Zavod_id='$table' limit 1");
if ($result->num_rows > 0) {
    $match_data = $result->fetch_array();
} else {
    echo "<pre class='text-warning text-center h4 m-5'>Závod neobsahuje žádná data.<br>Zkontrolujte záznam '$table' v tabulce 'match_config'</pre></h2>";
}

$stmt = $conn->prepare("SELECT firstname,lastname FROM site_admins WHERE username = ?");
$stmt->bind_param("s", $_SESSION['name']);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$line = mysqli_fetch_assoc($result);

require_once __DIR__ . '/../config/mail_texty.php';
$paymentBeforeClass = !empty($match_data['Payment_before']) ? '' : 'd-none';

// Určení pořadatele
$poradatel = "";
$sponzor = "";

if (!empty($match_data['Zavod_poradatel'])) {
    $normalized = normalize($match_data['Zavod_poradatel']);

    if (strpos($normalized, 'pelhrimov') !== false) {
        $poradatel = "pelhrimov";
    } elseif (strpos($normalized, 'eggenberg') !== false) {
        $poradatel = "eggenberg";
    }
}

$registracePozastavena = !empty($match_data['Zavod_registrace_pozastaveno']) ? '' : 'd-none';
$dnes = (new DateTime())->format("Y-m-d H:i:s");
?>

<!doctype html>
<html lang="cs">

<HEAD>
    <meta http-equiv="Content-Language" content="cs">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="../images/favicon.ico" />
    <title>Administrace závodu <?= htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" type="text/css" href="../styles/style_admin.css">
    <link rel="stylesheet" href="../styles/style_<?= "$poradatel" . ".css"; ?>">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Condensed%3A400%2C700%7CArimo%3A400%2C700&#038;ver=eb423f0ac3bea64e1037184f3b727fe6" type="text/css" media="all" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- dataTable https://datatables.net/download/ -->
    <script type="text/javascript" src="./js/datatable_conf.js"></script>
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.2.1/b-3.2.1/b-colvis-3.2.1/b-html5-3.2.0/b-print-3.2.0/cr-2.0.4/date-1.5.5/r-3.0.3/sb-1.8.1/sp-2.3.3/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.2.1/b-3.2.1/b-colvis-3.2.1/b-html5-3.2.0/b-print-3.2.0/cr-2.0.4/date-1.5.5/r-3.0.3/sb-1.8.1/sp-2.3.3/datatables.min.js"></script>
</HEAD>

<BODY>
    <?php require_once __DIR__ . '/components/toast.php'; ?>
    <div class="container">
        <div class="header">
            <div class="header-logo">
                <div class="logo-left"></div>
                <div class="text-center">
                    <a class="logo-text" href="<?= $web_adresa_admin ?>" target="_blank">
                        <?= htmlspecialchars($match_data['Zavod'], ENT_QUOTES, 'UTF-8') ?> - administrace</a><br>
                    <?php if ($match_data['Zavod_registrace_pozastaveno'] == "on") {
                        echo "<span class='text-danger tooltip '>[registrace je pozastavená]<span class='tooltiptext  lh-base'><strong>Spuštění registrace</strong> se provede v <span class='bg-success text-white' >Konfiguraci</span> - sekce <strong>Základní informace</strong></span></span>";
                    } elseif ($match_data['Payment_before'] == "on") {
                        echo "<span class='text-danger tooltip '>[platba startovného $match_data[Zavod_pocet_dni_na_platbu] dnů od registrace]<span class='tooltiptext'>Startovné se platí před závodem, nejpozději do $match_data[Zavod_pocet_dni_na_platbu] dnů od provedení registrace.<br><br>Nezaplatí-li závodník do té doby, pošle se ráno upozornění na chybějící platbu.<br><br>Jestliže nezaplatí ani po tomto upozornění, je druhý den večer automaticky vyřazen.</span></span>";
                    } else {
                        echo "<span class='text-danger tooltip '>[platba startovného na místě]<span class='tooltiptext'>Závodník platí v den závodu při prezenci <strong>nejpozději 30 minut před závodem</strong></span></span>";
                    }
                    ?>
                </div>
                <div class="logo-right"></div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-fixed-top bg-dark">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <?php if ($_SESSION['role'] === 'viewer'): ?>
                        <li class="nav-item">
                            <button type='button' class='btn btn-primary' onclick="window.location.href = 'export.php'">Export do PractiScore</button>
                        </li>
                    <?php endif; ?>

                    <?php if ($_SESSION['role'] === 'admin' or  $_SESSION['role'] === 'editor'): ?>
                        <li class="nav-item">
                            <button href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#match_configuration">Konfigurace</button>
                        </li>
                        <div class="dropdown" id="dropdownContainer1">
                            <button class="btn btn-dark dropdown-toggle mx-2" id="dropdownButton1">Závodníci</button>
                            <div class="custom-dropdown" id="customDropdown1">
                                <a href="" data-bs-toggle="modal" data-bs-target="#new_shooter">Nový závodník</a>
                                <a href="export.php">Export do PractiScore</a>
                            </div>
                        </div>
                        <div class="dropdown" id="dropdownContainer2">
                            <button class="btn btn-dark dropdown-toggle mx-2" id="dropdownButton2">Nastavení závodu</button>
                            <div class="custom-dropdown" id="customDropdown2">
                                <?php if ($_SESSION['role'] === 'admin'): ?>
                                    <a href="" data-bs-toggle="modal" data-bs-target="#manage_users">Uživatelé</a>
                                <?php endif; ?>
                                <a href="" data-bs-toggle="modal" data-bs-target="#manage_squads">Squady</a>
                                <a href="" data-bs-toggle="modal" data-bs-target="#manage_divisions">Divize</a>
                                <a href="" data-bs-toggle="modal" data-bs-target="#manage_categories">Kategorie</a>
                                <a href="" data-bs-toggle="modal" data-bs-target="#upload_stages">Nahrání situací</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </ul>
                <button type="button" class="btn btn-dark custom me-2"
                    id="userInfoBtn"
                    data-bs-toggle="popover"
                    data-bs-html="true"
                    data-bs-placement="bottom"
                    data-bs-title="Uživatel"
                    data-bs-content="
                        <dl class='row text-start'>
                            <dt class='col-4 text-end text-start pe-0'><strong>login:</strong></dt>
                                <dd class='col-8 ps-2'><?= $_SESSION['name'] ?></dd>
                            <dt class='col-4 text-end text-start pe-0'><strong>jméno:</strong></dt>
                                <dd class='col-8 ps-2'><?= $line['firstname'] . " " . $line['lastname']  ?></dd>
                            <dt class='col-4 text-end text-start pe-0'><strong>e-mail:</strong></dt>
                                <dd class='col-8 ps-2'><?= $line['email'] ?></dd>
                            <dt class='col-4 text-end text-start pe-0'><strong>role:</strong></dt>
                                <dd class='col-8 ps-2'><?= $_SESSION['role'] ?></dd>
                            <dt class='col-4 text-end text-start pe-0'><strong>oprávnění:</strong></dt>
                                <dd class='col-8 ps-2'><?= $admin_roles[$_SESSION['role']] ?></dd>
                            <dt class='col-4 text-end text-start pe-0'><strong>IP adresa:</strong></dt>
                                <dd class='col-8 ps-2'><?= $_SERVER['REMOTE_ADDR']; ?></dd>
                        </dl>
                ">
                    <i class="fa fa-user pe-1" style="font-size:15px"></i>
                    <span class="text-dashed"><?= $line['lastname'] . " " . $line['firstname']  ?></span>
                </button>
                <button class="btn btn-danger text-white btn-labeled" onclick="window.location.href = 'logout.php'">
                    <span class="btn-label "><i class="fa fa-sign-out" style="font-size:15px"></i></span>Odhlásit</span>
                </button>
            </div>
        </nav>