<?php 
    // require_once __DIR__ . '/../models/usine.php';
    // require_once __DIR__. '/../models/package.php';
    // require_once __DIR__. '/../models/connexion.php';
    $conn = Database::getInstance()->getConnection();

    class FactoryController{
        private $conn;
        private $usine;
        private $package;

        public function  __construct($conn){
            $this->conn=$conn;
            // $this->usine = new Usine;
            $this->package = new Package;
        }


        public function all(){
            require_once __DIR__. '/../views/factory/all-factory.php';
        }

        public function create(){
            $nom = $this->package->filtrer($_POST['nom']);
            if (Usine::create($this->conn,$nom)) {
                $_SESSION['insertok'] = [];
                $_SESSION['insertok']['data'] = $_POST;
                route::redirect('/factory/all-factory');
            }
        }


    }