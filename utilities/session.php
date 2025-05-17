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
            historique_acces::Insert(Database::getInstance()->getConnection(), Auth::user()->id, "Inactivité");
            $vue = $_SESSION['vue'];
            $id = Auth::user()->id;
            session_unset();
            session_destroy();

            session_start();
            $_SESSION['offff'] = true;
            $_SESSION['vue'] = [];
            $_SESSION['vue']['id'] = $id;
            $_SESSION['vue']['chemin'] = $vue;

            Route::redirect('/');
            exit;
        }
    }

    $_SESSION['LAST_ACTIVITY'] = time();
}
?>