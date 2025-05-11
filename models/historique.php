<?php
    class Historique{

        public static function insert($conn,$iduser,$idprod,$idatelier,$idusine,$action,$created_at,$created_by){
            $req = $conn->prepare("INSERT INTO historique(iduser,idprod,idatelier,idusine,action,created_at,created_by) VALUES(:iduser,:idprod,:idatelier,:idusine,:action,:created_at,:created_by)");
            $req->bindParam(':iduser', $iduser);
            $req->bindParam(':idprod', $idprod);
            $req->bindParam(':idatelier', $idatelier);
            $req->bindParam(':idusine', $idusine);
            $req->bindParam(':action', $action);
            $req->bindParam(':created_at', $created_at);
            $req->bindParam(':created_by', $created_by);
            if ($req->execute()) {
                return 1;
            }else {
                return 0;
            }
        }
        public static function all($conn){
            $req = $conn->prepare("SELECT * FROM historique");
            $req->execute();
            return $req->fetchAll();
        }

        public static function getWorkshop($conn,$idusine){
            $req = $conn->prepare("SELECT * FROM historique WHERE idusine =:idusine AND idatelier IS NOT NULL");
            $req->bindParam(':idusine', $idusine);
            $req->execute();
            return $req->fetchAll();
        }

        public static function getHistoryByUser($conn,$iduser){
            $req = $conn->prepare("SELECT * FROM historique WHERE iduser = :iduser");
            $req->bindParam(':iduser', $iduser);
            $req->execute();
            return $req->fetchAll();
        }

        public static function getAllIdUser($conn){
            $req = $conn->prepare("SELECT DISTINCT iduser  FROM historique");
            $req->execute();
            return $req->fetchAll();
        }
    }