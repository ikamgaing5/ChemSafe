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


        public function ifAtelierExist($conn, $nomatelier,$idusine){
            $req = $conn -> prepare("SELECT * FROM atelier WHERE nomatelier = :nomatelier AND idusine = :idusine");
            $req -> bindParam(':nomatelier', $nomatelier);
            $req -> bindParam(':idusine', $idusine);
            $req -> execute();
            return $req -> rowCount();
        }

        public function getLastId($conn){
            $req = $conn -> prepare("SELECT * FROM atelier");
            $req -> execute();
            $raw = $req -> fetchAll();
            $der = end($raw);
            return $der['idatelier'];
        }


        public function newAtelier($conn,$idusine,$nomatelier){
            if ($this ->ifAtelierExist($conn, $nomatelier, $idusine) >= 1 ) {
                return -1; // déjà dans la bd
            }else {
                $req = $conn -> prepare("INSERT INTO atelier(idusine,nomatelier) VALUES(:idusine,:nomatelier)");
                $req->bindParam(':idusine', $idusine);
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

        public function AllAtelier($conn,$idusine){
            $req = $conn -> prepare("SELECT * FROM atelier WHERE idusine = :idusine ORDER BY nomatelier ASC");
            $req->bindParam(':idusine',$idusine);
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

        public static function NbreAtelierByFactory($conn, $idusine){
            $req = $conn -> prepare("SELECT * FROM atelier WHERE idusine = :idusine");
            $req->bindParam(':idusine', $idusine);
            $req -> execute();
            return $req -> rowCount();
        }


        public static function getAteliers($conn,$idusine){
            $sql = "
            SELECT 
                a.idatelier,
                a.nomatelier AS nom_atelier,
                COUNT(DISTINCT c.idprod) AS total_produits,
                SUM(CASE WHEN p.fds IS NOT NULL AND p.fds != '' THEN 1 ELSE 0 END) AS produits_avec_fds,
                SUM(CASE WHEN p.fds IS NULL OR p.fds = '' THEN 1 ELSE 0 END) AS produits_sans_fds
            FROM 
                atelier a
            LEFT JOIN 
                contenir c ON a.idatelier = c.idatelier
            LEFT JOIN 
                produit p ON c.idprod = p.idprod
            WHERE 
                a.idusine = :idusine
            GROUP BY 
                a.idatelier, a.nomatelier
            ORDER BY 
                a.nomatelier
            ";
            $req = $conn->prepare($sql);
            $req->execute(['idusine' => $idusine]);
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function gettAtelierss($conn,$isSuperAdmin,$idusine){
            if ($isSuperAdmin) {
                // Pas de filtre par usine
                $sql = "
                    SELECT 
                        a.idatelier,
                        a.nomatelier AS nom_atelier,
                        COUNT(DISTINCT c.idprod) AS total_produits,
                        SUM(CASE WHEN p.fds IS NOT NULL AND p.fds != '' THEN 1 ELSE 0 END) AS produits_avec_fds,
                        SUM(CASE WHEN p.fds IS NULL OR p.fds = '' THEN 1 ELSE 0 END) AS produits_sans_fds
                    FROM 
                        atelier a
                    LEFT JOIN 
                        contenir c ON a.idatelier = c.idatelier
                    LEFT JOIN 
                        produit p ON c.idprod = p.idprod
                    GROUP BY 
                        a.idatelier, a.nomatelier
                    ORDER BY 
                        a.nomatelier
                ";
                $req = $conn->prepare($sql);
                $req->execute();
            } else {
                // Filtrage classique par usine
                $sql = "
                    SELECT 
                        a.idatelier,
                        a.nomatelier AS nom_atelier,
                        COUNT(DISTINCT c.idprod) AS total_produits,
                        SUM(CASE WHEN p.fds IS NOT NULL AND p.fds != '' THEN 1 ELSE 0 END) AS produits_avec_fds,
                        SUM(CASE WHEN p.fds IS NULL OR p.fds = '' THEN 1 ELSE 0 END) AS produits_sans_fds
                    FROM 
                        atelier a
                    LEFT JOIN 
                        contenir c ON a.idatelier = c.idatelier
                    LEFT JOIN 
                        produit p ON c.idprod = p.idprod
                    WHERE 
                        a.idusine = :idusine
                    GROUP BY 
                        a.idatelier, a.nomatelier
                    ORDER BY 
                        a.nomatelier
                ";
                $req = $conn->prepare($sql);
                $req->execute(['idusine' => $idusine]);
            }
            return $req->fetchAll(PDO::FETCH_ASSOC);
            
        }



    }