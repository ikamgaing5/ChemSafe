<?php 

    
    require_once __DIR__. '/../models/package.php';
    require_once __DIR__. '/../models/atelier.php';
    require_once __DIR__. '/../models/fds.php';
    // require_once __DIR__. '/../utilities/session.php';
    require_once __DIR__. '/../models/contenir.php';
    // require_once __DIR__. '/../models/connexion.php';
    $conn = Database::getInstance()->getConnection();
    class FdsController{
        private $conn;
        private $produit;
        private $package;
        private $fds;

        public function __construct($conn){
            $this->conn = $conn; 
            $this->produit = new Produit;
            $this->package = new Package;
            $this->fds = new FDS;
        }

        public function Insert($params){
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              echo  $idprod = $_POST['idprod']; echo "<br>";
             echo   $physique = $this->package->filtrer($_POST['physique']); echo "<br>";
             echo   $sante = $this->package->filtrer($_POST['sante']); echo "<br>";
             echo   $ppt = $this->package->filtrer($_POST['ppt']); echo "<br>";
             echo   $stabilite = $this->package->filtrer($_POST['stabilite']); echo "<br>";
             echo   $eviter = $this->package->filtrer($_POST['eviter']); echo "<br>";
             echo   $incompatible = $this->package->filtrer($_POST['incompatible']); echo "<br>";
              echo  $reactivite = $this->package->filtrer($_POST['reactivite']); echo "<br>";
              echo  $manipulation = $this->package->filtrer($_POST['manipulation']); echo "<br>";
             echo   $secours = $this->package->filtrer($_POST['secours']); echo "<br>";
             echo   $epi = $this->package->filtrer($_POST['epi']); echo "<br>";
             $result = $this->fds->create(conn: $this->conn,idprod: $idprod,physique: $physique,sante: $sante,ppt: $ppt,stabilite: $stabilite, eviter: $eviter,incompatible: $incompatible,reactivite: $reactivite,stockage: $manipulation,secours: $secours,epi: $epi);
                if ($result == 1) {
                    $_SESSION['insertinfoFDS'] = true;
                    echo "insertion ok";
                    // Route::redirect('/'.$_SESSION['chemin']);
                }elseif ($result == 0) {
                    echo "insertion pas ok";
                }elseif ($result == -1) {
                    echo "doublon";
                }

            }else {
                $idprod = IdEncryptor::decode($params['idprod']);
                require_once __DIR__. '/../views/fds/new-fds.php';
            }
        }
    }