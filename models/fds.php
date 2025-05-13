<?php 

    class FDS {


// donner la possibilité à l'utilisateur de saisir ces informations à la création du produit ou plus tard

        public function create($conn,$idprod,$physique,$sante,$ppt,$stabilite,$eviter,$incompatible,$reactivite,$stockage,$secours,$epi){
            if ($this->Exist(conn: $conn, id: $idprod) == 0) {
                $req = $conn -> prepare("INSERT INTO infofds (idprod, physique, sante, ppt, stabilite, eviter, incompatible,reactivite, stockage,secours, epi) VALUES (:idprod, :physique, :sante, :ppt, :stabilite, :eviter, :incompatible, :reactivite, :stockage, :secours, :epi)");
                $req -> bindParam(':idprod', $idprod);
                $req -> bindParam(':physique', $physique);
                $req -> bindParam(':sante', $sante);
                $req -> bindParam(':ppt', $ppt);
                $req -> bindParam(':stabilite', $stabilite);
                $req -> bindParam(':eviter', $eviter);
                $req -> bindParam(':incompatible', $incompatible);
                $req -> bindParam(':reactivite', $reactivite);
                $req -> bindParam(':stockage', $stockage);
                $req -> bindParam(':secours', $secours);
                $req -> bindParam(':epi', $epi);
                if ($req -> execute() ) {
                    return 1; // insertion ok
                }else {
                    return 0; // echec insertion
                }
            }else {
                return -1; // produit déjà dans la base
            }
           
        }

        public static function Exist($conn, $id){
            $req = $conn -> prepare("SELECT * FROM infofds WHERE idprod = :idprod");
            $req -> bindParam(':idprod', $id);
            $req -> execute();
            return $req -> rowCount();
        }

        public static function ProduitSansInfoFDS($conn){
            $req = $conn->prepare("SELECT p.idprod FROM produit p WHERE idprod NOT IN (SELECT idprod FROM infofds)");
            $req->execute();
            return $req->fetchAll();
        }



        public static function AllInfo($conn,){
            $req = $conn -> prepare("SELECT * FROM infofds");
            $req -> execute();
            return $req -> fetchAll();
        }

        public static function OneInfo($conn, $id){
            $req = $conn -> prepare("SELECT * FROM infofds WHERE idinfo = :id");
            $req -> bindParam(':id', $id);
            $req -> execute();
            return $req -> fetch();
        }

        public static function getInfoByProd($conn, $id){
            $req = $conn -> prepare("SELECT * FROM infofds WHERE idprod = :id");
            $req -> bindParam(':id', $id);
            $req -> execute();
            return $req -> fetch();
        }


        public  function Delete($conn, $id){
            $req = $conn -> prepare("DELETE FROM infofds WHERE idinfo = :id");
            $req -> bindParam(':id',$id);
            $req -> execute();
        }


        public function Update($conn, $id,$physique,$sante,$ppt,$stabilite,$eviter,$incompatible,$reactivite,$stockage,$secours,$epi){
            
                $req = $conn -> prepare("UPDATE infofds SET physique = :physique, sante = :sante ,ppt = :ppt, stabilite = :stabilite, eviter = :eviter, incompatible = :incompatible, reactivite = :reactivite, stockage = :stockage, secours = :secours, epi = :epi WHERE idprod = id");
                $req -> bindParam(':id', $id);
                $req -> bindParam(':physique', $physique);
                $req -> bindParam(':sante', $sante);
                $req -> bindParam(':ppt', $ppt);
                $req -> bindParam(':stabilite', $stabilite);
                $req -> bindParam(':eviter', $eviter);
                $req -> bindParam(':incompatible', $incompatible);
                $req -> bindParam(':reactivite', $reactivite);
                $req -> bindParam(':stockage', $stockage);
                $req -> bindParam(':secours', $secours);
                $req -> bindParam(':epi', $epi);
                if ($req -> execute()) {
                    return 1; // Modification ok
                }else {
                    return -1; // Problème de modification
                }
        }



    }



?>