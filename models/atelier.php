<?php

    // namespace Models;
    class Atelier {


        public function Exist($conn,$nomatelier, $id){
            $req = $conn -> prepare("SELECT * FROM atelier WHERE nomatelier = :nomatelier AND idatelier != :id");
            $req -> bindParam(':nomatelier', $nomatelier);
            $req -> bindParam(':id', $id);
            $req -> execute();
            return $req -> rowCount();
        }

        public static function getAteliersByProduitId($conn, $idprod) {
            $req = $conn->prepare("SELECT a.idatelier, a.nomatelier FROM atelier a JOIN contenir c ON c.idatelier = a.idatelier WHERE c.idprod = :idprod");
            $req->bindParam(':idprod', $idprod, PDO::PARAM_INT);
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }


        public function ifAtelierExist($conn, $nomatelier){
            $req = $conn -> prepare("SELECT * FROM atelier WHERE nomatelier = :nomatelier ");
            $req -> bindParam(':nomatelier', $nomatelier);
            $req -> execute();
            return $req -> rowCount();
        }


        public function newAtelier($conn,$nomatelier){
            if ($this ->ifAtelierExist($conn, $nomatelier) >= 1 ) {
                return -1; // déjà dans la bd
            }else {
                $req = $conn -> prepare("INSERT INTO atelier(nomatelier) VALUES(:nomatelier)");
                $req -> bindParam(':nomatelier', $nomatelier);
                if ($req -> execute()) {
                    return 1;
                }else {
                    return 0; // problème d'insertion
                }
            }
        }


        public function updateAtelier($conn,$nomatelier,$idatelier){
            if ($this ->Exist($conn, $nomatelier, $idatelier)>0) {
                return -1 ; // déjà dans la bd
            }else {
                $req = $conn -> prepare("UPDATE atelier SET nomatelier = :nomatelier  WHERE idatelier = :idatelier");
                $req -> bindParam(':idatelier', $idatelier);
                $req -> bindParam(':nomatelier', $nomatelier);
                if ($req -> execute()) {
                    return 1;
                }else {
                    return 0 ; // problème d'insertion
                }
            }
        }

        public function Delete($conn, $id){
            $req = $conn -> prepare("DELETE FROM atelier WHERE idatelier = :idatelier");
            $req -> bindParam(":idatelier", $id);
            return $req -> execute();
        }

        public function AllAtelier($conn){
            $req = $conn -> prepare("SELECT * FROM atelier ORDER BY nomatelier ASC");
            $req -> execute();
            return $req -> fetchAll();
        } 

        public function getAtelierById($conn, $idatelier){
            $req = $conn -> prepare("SELECT * FROM atelier WHERE idatelier = :idatelier");
            $req -> bindParam(':idatelier', $idatelier);
            $req -> execute();
            return $req -> fetch();
        }

        public function getName($conn,$idatelier){
            $req = $conn -> prepare("SELECT * FROM atelier WHERE idatelier = :idatelier");
            $req -> bindParam(':idatelier', $idatelier);
            $req -> execute();
            $raw = $req -> fetch();
            return $raw['nomatelier'];
        }
        

        public function NbreAtelier($conn){
            $req = $conn -> prepare("SELECT * FROM atelier");
            $req -> execute();
            return $req -> rowCount();
        }



    }