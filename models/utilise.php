<?php
    class Utilise{

        public function Insert($conn,$idpro, $idatelier){
            $req = $conn -> prepare("INSERT INTO utilise(idprod, idatelier) VALUES (:idprod, :idatelier)");
            $req -> bindParam(':idpro', $idpro);
            $req -> bindParam(':idatelier', $idatelier);
            return $req -> execute();
        }

        public function SelectAll($conn){
            $req = $conn -> prepare("SELECT * FROM utilise");
            return $req -> fetchAll();
        }

        public function SelectOne($conn, $idatelier){
            $req = $conn -> prepare("SELECT * FROM utilise WHERE idatelier = :idprod");
            $req -> bindParam(':idatelier', $idatelier);
            return $req -> fetchAll();
        }

        public function Delete($conn, $idprod){
            $req = $conn -> prepare("DELETE FROM utilise WHERE idprod = :idprod"); $req -> bindParam(':idprod', $idprod);
            return $req -> execute();
        }
    }