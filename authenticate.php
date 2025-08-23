<?php
include "header.php";
session_start();

if (empty($_POST['username']) || empty($_POST['password'])) {
    exit('Zadejte jméno a heslo');
}
if ($stmt = $conn->prepare('SELECT id, password FROM site_admins WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        if (password_verify($_POST['password'], $password)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            header('Location: ./admin/index.php');
        } else {
            include './components/modal-warning.php';
            WarningModal(
                "Přihlášení do administrace závodu",
                "login.php",
                "<div class='col-12 fw-bolder text-danger'>Chyba autentizace.",
                "Zadejte správné heslo a zkuste to znovu.",
                "<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'login.php';\">Zpět na přihlášení</button>"
            );
        }
    } else {
        include './components/modal-warning.php';
        WarningModal(
            "Přihlášení do administrace závodu",
            "login.php",
            "<div class='col-12 fw-bolder text-danger'>Chyba autentizace - uživatel '" . htmlspecialchars($_POST['username']) . "' neexistuje.",
            "Zadejte správné uživatelské jméno a heslo a zkuste to znovu.",
            "<button type='button' class='btn btn-outline-danger' onclick=\"window.location.href = 'login.php';\">Zpět na přihlášení</button>"
        );
    }
    $stmt->close();
}
include "footer.php";
