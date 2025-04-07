<?php 

    
    require_once __DIR__. '/../models/package.php';
    require_once __DIR__. '/../models/atelier.php';
    require_once __DIR__. '/../utilities/session.php';
    require_once __DIR__. '/../models/contenir.php';
    require_once __DIR__. '/../models/connexion.php';
    $conn = Database::getInstance()->getConnection();
    class FdsController{
        private $conn;
        private $produit;
        private $package;

        public function __construct($conn){
            $this->conn = $conn; 
            $this->produit = new Produit;
            $this->package = new Package;
        }

        public function Insert(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
            }else {
                require_once __DIR__. '/../views/fds/new-fds.php';
            }
        }
    }