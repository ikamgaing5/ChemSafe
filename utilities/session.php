<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // $inactivityLimit = 60;
    // if (isset($_SESSION['LAST_ACTIVITY'])) {
    //     $inactiveTime = time() - $_SESSION['LAST_ACTIVITY'];

    //     if ($inactiveTime > $inactivityLimit) {
    //         unset($_SESSION['log']);
    //         // $_SESSION['deconnect'] = true;
    //         Route::redirect('/');
    //     }
    // }
    // $_SESSION['LAST_ACTIVITY'] = time();
?>