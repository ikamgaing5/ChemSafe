<?php

require_once __DIR__ . '/../utilities/session.php';
require_once __DIR__ . '/../core/Middleware.php';

class AuthMiddleware extends Middleware {
    public function handle() {
        if (!isset($_SESSION['log'])) {
            Route::redirect('/');
        }
        return true;
    }
}

class AuthAdminMiddleware extends Middleware {
    public function handle() {
        if (isset($_SESSION['log']) && $_SESSION['log']['type'] == 'admin') {
            Route::redirect('/');
        }
        return true;
    }
}

class AuthSuperAdminMiddleware extends Middleware {
    public function handle() {
        if (!isset($_SESSION['superadmin'])) {
            Route::redirect('/');
        }
        return true;
    }
}