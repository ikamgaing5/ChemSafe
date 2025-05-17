<?php


// require_once __DIR__. '/../models/package.php';
// require_once __DIR__. '/../models/user.php';
// require_once __DIR__. '/../models/connexion.php';

$conn = Database::getInstance()->getConnection();
class HistoriqueController
{
    private $user;
    private $package;
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->user = new User();
        $this->package = new Package;
    }

    public function user()
    {
        require_once __DIR__ . '/../views/history/user.php';
    }

    public function workshop()
    {
        require_once __DIR__ . '/../views/history/workshop.php';
    }
}