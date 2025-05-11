<?php
    class Possede{
        public static function add($conn,$iddanger,$idprod){
            $req = $conn->prepare("INSERT INTO possede(iddanger, idprod) VALUES(:iddanger, :idprod)");
            $req->bindParam(':iddanger', $iddanger);
            $req->bindParam(':idprod', $idprod);
            return $req->execute();
        }

        public static function getDangerByDanger($conn,$iddanger){
            $req = $conn->prepare("SELECT * FROM possede WHERE iddanger = :iddanger");
            $req->bindParam(':iddanger', $iddanger);
            $req->execute();
            return $req->fetchAll();
        }

        public static function getDangerByProduit($conn,$idprod){
            $req = $conn->prepare("SELECT * FROM possede WHERE idprod = :idprod");
            $req->bindParam(':idprod', $idprod);
            $req->execute();
            return $req->fetchAll();
        }

        public function delete($conn,$idprod){
            $req = $conn->prepare("DELETE FROM possede WHERE idprod =:idprod");
            $req->bindParam(':idprod', $idprod);
            return $req->execute();
        }
    }