<?php 
/*
error_log('SESSION token: ' . ($_SESSION['token'] ?? 'NONE'));
error_log('POST token: '    . ($_POST['token']    ?? 'NONE'));
error_log('SESSION ID: '    . session_id());
*/
    // --- kontrola CSRF tokenu ---

    if (!isset($_POST['token'], $_SESSION['token']) || $_POST['token'] !== $_SESSION['token']) {
        http_response_code(403);
        $_SESSION['toast'] = [
            'type' => 'danger',
            'message' => 'Registrujte se POUZE kliknutím na tlačítko Registrace. Neklikejte na něj víckrát nebo neobnovujte stránku.',
            'duration' => 2500
        ];
        header("Location: index.php");
        exit;
    }
    // token po použití zneplatníme
    unset($_SESSION['token']);
    // --- honeypot (robots) ---
    if (!empty($_POST['gender'])) {
        exit('Detekován Spam.');
    }
?>