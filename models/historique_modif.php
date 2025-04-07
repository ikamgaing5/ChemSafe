<?php
    class historique_modif{


        public function Insert($conn,$iduser,$idprod) {
            $req = $conn -> prepare("INSERT INTO historique_modif(idprod,iduser,created_at) VALUES(:idprod,:iduser,:created_at)");
            $req -> bindParam(':idprod', $idprod);
            $req -> bindParam(':iduser', $iduser);
            $created_at = date("Y-m-d H:i:s");
            $req -> bindParam(':created_at', $created_at);
           return $req -> execute();
        }

        public function SelectAll($conn){
            $req = $conn -> prepare("SELECT * FROM historique_modif");
            $req -> execute();
            return $req -> fetchAll();
        }

        public function SelectOne($conn, $iduser){
            $req = $conn -> prepare("SELECT * FROM historique_modif WHERE iduser = :iduser");
            $req -> bindParam('iduser', $iduser);
            $req -> execute();
        }
    }