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
    }