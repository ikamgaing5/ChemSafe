<?php
    class historique_acces{


        public function Insert($conn,$iduser) {
            $req = $conn -> prepare("INSERT INTO historique_acces(iduser,created_at) VALUES(:iduser,:created_at)");
            $req -> bindParam(':iduser', $iduser);
            $created_at = date("Y-m-d H:i:s");
            $req -> bindParam(':created_at', $created_at);
           return $req -> execute();
        }

        public function SelectAll($conn){
            $req = $conn -> prepare("SELECT * FROM historique_acces");
            $req -> execute();
            return $req -> fetchAll();
        }

        public function SelectOne($conn, $iduser){
            $req = $conn -> prepare("SELECT * FROM historique_acces WHERE iduser = :iduser");
            $req -> bindParam('iduser', $iduser);
            $req -> execute();
        }
    }