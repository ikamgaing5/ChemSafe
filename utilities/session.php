<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$inactivityLimit = 1200; // durée en secondes

// Vérifie si l'utilisateur est connecté
if (isset($_SESSION['log'])) {
    if (isset($_SESSION['LAST_ACTIVITY'])) {
        $inactiveTime = time() - $_SESSION['LAST_ACTIVITY'];

        if ($inactiveTime > $inactivityLimit) {
            session_unset();
            session_destroy();

            session_start();
            $_SESSION['offff'] = true;


            Route::redirect('/');
            exit;
        }
    }

    $_SESSION['LAST_ACTIVITY'] = time();
}
?>
