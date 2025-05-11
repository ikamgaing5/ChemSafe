<?php 
   
    $conn = Database::getInstance()->getConnection();

    class AtelierController{
        private $conn;
        private $package;
        private $atelier;
        private $contenir;

        public function __construct($conn){
            $this -> conn = $conn;
            $this -> package = new Package;
            $this -> atelier = new Atelier;
            $this -> contenir = new Contenir;
        }


        public function all($params){
            $idusine = IdEncryptor::decode($params['idusine']);
            require_once __DIR__. '/../models/atelier.php';
            require_once __DIR__. '/../models/produit.php';
            $atelier = new Atelier();
            $produit = new Produit();
            require_once __DIR__. '/../views/workshop/all-workshop.php';
        }

        public function alls(){
            // $idusine = IdEncryptor::decode($params['idusine']);
            require_once __DIR__. '/../models/atelier.php';
            require_once __DIR__. '/../models/produit.php';
            $atelier = new Atelier();
            $produit = new Produit();
            require_once __DIR__. '/../views/workshop/all-workshop.php';
        }

        public function Insert(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                # code...
            }else {
                require_once __DIR__. '/../views/workshop/new-workshop.php';
            }
        }

        public function editd(){
            $id = $_POST['idatelier'];
            $nom = $this->package -> filtrer($_POST['nom']);
            // $oldname = $this->package->filtrer($_POST['oldvalue']);
            $req = $this -> atelier -> updateAtelier($this->conn,$nom,$id);
            var_dump($req);
            if ($req == -1) {
                // déjà en bd
                echo "déjà en bd";
                $_SESSION['error'] = [];
                $_SESSION['error']['data'] = $_POST;
                $_SESSION['error']['inbd'] = true;
                // Route::redirect('/workshop/all-workshop');
            }elseif ($req == 0) {
                echo "problème insertion";
            }elseif ($req == 1) {
               echo "insertion ok";
            }
        }

        public function edit(){
            $id = $_POST['idatelier'];
           echo $nom = $this->package->filtrer($_POST['nom']);
           echo $old = $this->package->filtrer($_POST['oldvalue']);
        
           if ($nom === $old) {
            echo "true";
           }
            if ($nom === $old) {
                $_SESSION['error'] = [];
                $_SESSION['error']['data'] = $_POST;
                $_SESSION['error']['inbd'] = true;
                Route::redirect('/workshop/all-workshop');
            }
        
            $req = $this->atelier->updateAtelier($this->conn, $nom, $id);
        
            if ($req == 0) {
                $_SESSION['error'] = [];
                $_SESSION['error']['data'] = $_POST;
                $_SESSION['error']['errorInsert'] = true;
                // Route::redirect('/workshop/all-workshop');
            } elseif ($req == 1) {
                    $_SESSION['error'] = [];
                    $_SESSION['error']['data'] = $_POST;
                    $_SESSION['error']['success'] = true;
                    echo "ok";
                    // Route::redirect('/workshop/all-workshop');
            }
        }

        public function add(){
            $idusine = ($_POST['idusine']);
            $nom = $this -> package -> filtrer($_POST['nom']);
            $chemin = $_POST['chemin'];
            $req = $this -> atelier -> newAtelier($this->conn,$idusine,$nom);
            if ($req == -1) {
                // echo "déjà en bd";
                // echo $idusine;
                $_SESSION['error'] = [];
                $_SESSION['error']['data'] = $_POST;
                $_SESSION['error']['inbd'] = true;
                Route::redirect($chemin);
            }elseif ($req == 1) {
                $_SESSION['insertok'] = [];
                $_SESSION['insertok']['temoin'] = true;
                $_SESSION['insertok']['data'] = $_POST;
                $created_at = date("Y-m-d H:i;s");
                Historique::insert($this->conn,null,null,$this->atelier->getLastId($this->conn),Auth::user()->idusine,"Création Atelier",$created_at,Auth::user()->id);
                Route::redirect($chemin);
            }else {
                echo "problème d'insertion";
            }

        }

        public function delete(){
            $id = $_POST['idatelier'];
            $usine = $_POST['usine'];
            if ($this -> contenir->NbreProduitParAtelier($this->conn,$id) > 0) {
                // suppression impossible car l'atelier contient des produits
                $_SESSION['delete'] = [];
                $_SESSION['delete']['errorDelete'] = true;
                $_SESSION['delete']['data'] = $_POST;
                Route::redirect('/workshop/all-workshop/'.$usine);
            }
            if ($this->atelier -> Desactive($this->conn,$id)) {
                $_SESSION['delete'] = [];
                $_SESSION['delete']['deleteok'] = true;
                $_SESSION['delete']['data'] = $_POST;
                $created_at = date("Y-m-d H:i;s");
                Historique::insert($this->conn,null,null,$id,Auth::user()->idusine,"Suppression Atelier",$created_at,Auth::user()->id);
                Route::redirect('/workshop/all-workshop/'.$usine);
            }else {
                $_SESSION['delete'] = [];
                $_SESSION['delete']['deleteerror'] = true;
                $_SESSION['delete']['data'] = $_POST;
                Route::redirect('/workshop/all-workshop/'.$usine);
            }

            
            
            // $this -> atelier -> Delete($this-> conn,$id);
        }

        public function dashboard(){
            $idusine = $_SESSION['idusine'];
            $resultats = $this->atelier->getAteliers($this->conn,$idusine);
        
            // Envoi des données au format JSON
            header('Content-Type: application/json');
            echo json_encode($resultats);
        }

        
    }