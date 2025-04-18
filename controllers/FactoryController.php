<?php 
    require_once __DIR__ . '/../models/usine.php';
    require_once __DIR__. '/../models/connexion.php';
    $conn = Database::getInstance()->getConnection();

    class FactoryController{
        private $conn;
        private $usine;

        public function  __construct($conn){
            $this->conn=$conn;
            $this->usine = new Usine;
        }


        public function all(){
            require_once __DIR__. '/../views/factory/all-factory.php';
        }
    }