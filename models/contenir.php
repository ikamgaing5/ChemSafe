<?php
    class Contenir{

        public function Insert($conn,$idprod, $idatelier){
            $req = $conn -> prepare("INSERT INTO contenir(idprod, idatelier) VALUES (:idprod, :idatelier)");
            $req -> bindParam(':idprod', $idprod);
            $req -> bindParam(':idatelier', $idatelier);
            return $req -> execute();
        }

        public function SelectAll($conn){
            $req = $conn -> prepare("SELECT * FROM contenir");
            $req -> execute();
            return $req -> fetchAll();
        }

        public function SelectOne($conn, $idatelier){
            $req = $conn -> prepare("SELECT * FROM contenir WHERE idatelier = :idatelier");
            $req -> bindParam(':idatelier', $idatelier);
            $req -> execute();
            return $req -> fetchAll();
        }

        public function NbreProduitParAtelier($conn, $idatelier){
            $req = $conn -> prepare("SELECT * FROM contenir WHERE idatelier = :idatelier");
            $req -> bindParam(':idatelier', $idatelier);
            $req -> execute();
            return $req -> rowCount();
        }   

        public function NbresProduitFDS($conn,$idatelier,$idprod){
            $req = $conn -> prepare("SELECT * FROM contenir WHERE idatelier = :idatelier AND idprod = :idprod");
            $req -> bindParam(':idatelier', $idatelier);
            $req -> bindParam(':idprod', $idprod);
            $req -> execute();
            return $req -> rowCount();
        }


        public function getProduitByAtelier($conn,$idatelier){
            $req = $conn -> prepare("SELECT * FROM contenir WHERE idatelier = :idatelier");
            $req -> bindParam(':idatelier', $idatelier);
            $req -> execute();
            return $req -> fetchAll();
        }

        public function Delete($conn, $idprod){
            $req = $conn -> prepare("DELETE FROM contenir WHERE idprod = :idprod"); 
            $req -> bindParam(':idprod', $idprod);
            return $req -> execute();
        }

 
    }